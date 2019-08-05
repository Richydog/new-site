<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {
        $user = User::orderBy('id', 'desc')->paginate(20);
        return view('admin.users.index', compact('user'));
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

        ]);
        $user = User::create(array(
            'name' => $request['name'],
            'email' => $request['email'],

        ));
        return redirect()->route('users.show', $user);
    }

    public function show(User $user)
    {

        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)

    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users,id,' . $user->id,
        ]);
        $user->update($data);
        return view('admin.users.show', compact('user'));

    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect('admin.users.index');
    }

    public function verify(User $user)
    {
        $user->verify();

        return view('admin.users.show',compact('user'));
    }



}
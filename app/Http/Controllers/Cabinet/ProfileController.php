<?php

namespace App\Http\Controllers\Cabinet;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{ public function index()
{
    $user = Auth::user();

    return view('cabinet.profile.home', compact('user'));
}

    public function edit()
    {
        $user = Auth::user();

        return view('cabinet.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $data=$this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],]);


$user=Auth::user();
       $user->update($data);
        return redirect()->route('profilyhome',compact('user'));
      // return view('cabinet.profile.home');
    }
}

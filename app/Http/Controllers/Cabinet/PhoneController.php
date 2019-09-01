<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
class PhoneController extends Controller
{
    public function request(Request $request){

        $user=Auth::user();
        try{
            $token=$user->requestPhoneVerification(Carbon::now());;
        }catch (\DomainException $e){
            $request->session()->flash('error',$e->getMessage());
        }
        return redirect()->route('profilyphone');
    }

    public function form(){
        $user=Auth::user();
        return view('cabinet.profile.phone',compact('user'));
    }
    public function verify(Request $request){
        $this->validate($request,[
            'token'=>'required|string|max:255',
        ]);
        $user=Auth::user();

        try{
            $user->verifyPhone($request['token'],Carbon::now());
        }catch (\DomainException $e){
            return redirect()->route('profilyphone')->with('error',$e->getMessage());
        }
        return redirect()->route('profilyhome');
    }
}

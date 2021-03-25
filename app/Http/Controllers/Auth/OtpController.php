<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
class OtpController extends Controller
{	

	public function otpform($id){

		$user = User::find($id);

		$mobile = $user->mobile;
		$id = $user->id;

		return view('auth.otp', compact('mobile', 'id'));
	}

	public function checkotp(Request $request){

		$user = User::find($request->id);
		
		if($user->otp === $request->otp){
			$otpUser = User::find($user->id);
			$otpUser->verified = 1;
			$otpUser->otp = null;
			$otpUser->save();

			return redirect()->route('login')->with('active', 'Account activated successfully. Please login.');
		}
		else{
			return back()->with('status', 'OTP code is invalid. Please try again.');
		}
	}
}

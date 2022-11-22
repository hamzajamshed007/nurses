<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'usertype' => 'required',
            'phone' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $accessToken = Str::random(60);

        $password = Hash::make($request->password);
        
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $image = date('YmdHi').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $image);
        }

        $User = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => $password,
            'usertype' => $request->usertype,
            'accesstoken' => $accessToken,
            'phone' => $request->phone,
            'image' => 'images/'.$image,
        ]);
        
        $msg = 'User Registered successfully';

        return response()->json(['message'=>$msg,'user'=>$User], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $UserEmail = User::where('email',$request->email)->where('usertype',$request->usertype)->first();

        if($UserEmail)
        {
            if(Hash::check($request->password, $UserEmail->password))
            {
                $User = User::where('id',$UserEmail->id)->first();

                $msg = 'User Login successfully';
    
                return response()->json(['message'=>$msg,'user'=>$User], 200, [], JSON_UNESCAPED_SLASHES);
            }
            else
            {
                $msg = 'Password does not Match';

                return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
            }

        }
        else
        {
            $msg = 'User does not exist';

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }

    public function forgot_password(Request $request)
    {
        $otpNumber = rand(100000,900000);

        $details = [
            'email' => $request->email,
            'otpNumber' => $otpNumber,
        ];

        $User = User::where('email',$request->email)->first();
        if($User)
        {
            User::where('email',$request->email)->update([
                'otp' => $otpNumber,
            ]);
        }
        else
        {
            $msg = "Email Not Found";

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }

        Mail::to($request->email)->send(new \App\Mail\ForgotPassword($details));
       
        $msg = "Email Sent Successfully";

        return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function otp_verification(Request $request)
    {
        $User = User::where('email',$request->email)->first();

        if($User)
        {
            if($User->otp == $request->otp)
            {            
                $msg = "OTP is True";
    
                return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
            }
            else
            {
                $msg = "OTP is False";
    
                return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
            }
        }
        else
        {
            $msg = "Email Not Found";

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }

    }

    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::where('email',$request->email)->first();

        if($User)
        {
            if($User->otp == $request->otp)
            {
                $user = User::where('email', $request->email)->update(
                    ['password' => Hash::make($request->new_password)]
                );            
    
                return response()->json(['message'=>'Password Reset Successfully'], 200, [], JSON_UNESCAPED_SLASHES);
            }
            else
            {
                $msg = "OTP is not Correct";
    
                return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
            }
        }
        else
        {
            $msg = "Email Not Found";

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $User = User::where('email',$request->email)->first();

        if($User)
        {
            if(Hash::check($request->current_password, $User->password)){

                $user = User::where('email', $request->email)->update(
                    ['password' => Hash::make($request->new_password)]
                );
                
                return response()->json(['message'=>'Password Updated Successfully'], 200, [], JSON_UNESCAPED_SLASHES);
  
            }
            else{
                $msg = "Old Password Doesn't match!";

                return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
            }

        }
        else
        {
            $msg = "Email Not Found";

            return response()->json(['message'=>$msg], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }
    // RSCp7Xb%4Tlf
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SessionUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'user' => $user,
        ]);

    }

    public function login(Request $request){
        $datecheck = [
            'email' => $request->email,
            'password' => $request->password,
        ];
      
        //B1: check user có tài khoản
        if(auth()->attempt($datecheck)){
            dd(auth()->user());
            $checktoken = SessionUser::where('user_id', auth()->id())->first();
            if(empty($checktoken)){
                $sessionUser = SessionUser::create([
                    'token' => Str::random(40),
                    'refresh_token' => Str::random(40),
                    'token_expried' => date('Y-m-d H:i:s', strtotime('+30 days')),
                    'refresh_token_expried' => date('Y-m-d H:i:s', strtotime('+360 days')),
                    'user_id' => Auth::id(),
                ]);
            }else{
                $sessionUser = $checktoken;
            }
            return response()->json([
                'code' => 200,
                'data' => $sessionUser,
            ], 200);   
        }    
    }

    public function refreshtoken(Request $request){
        $token = $request->header('token');
        $checktoken = SessionUser::where('token', $token)->first();
        if(!empty($checktoken))
        {
            if($checktoken->token_expried < date('Y-m-d H:i:s'))
            {
                $checktoken -> update([
                    'token' => Str::random(40),
                    'refresh_token' => Str::random(40),
                    'token_expried' => date('Y-m-d H:i:s', strtotime('+30 days')),
                    'refresh_token_expried' => date('Y-m-d H:i:s', strtotime('+360 days')),
                ]);
            }
        }else
        {
            return response()->json([
                'code' => 401,
                'message' => 'token không hợp lệ'
            ], 401);
        }

        return response()->json([
            'code' => 200,
            'data' => $checktoken
        ], 200);
    }

    public function deleteToken(Request $request){
        $token = $request->header('token');
        $checktoken = SessionUser::where('token', $token)->first();
        if(!empty($checktoken))
        {
            $checktoken->delete();
            return response()->json([
                'code' => 200,
                'message' => 'delete thành công',
            ], 200);
        }else
        {
            return response()->json([
                'code' => 401,
                'message' => 'token không hợp lệ',
            ], 401);
        }
        
    }
}
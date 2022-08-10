<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SessionUser;
use App\Models\Post;

class PostsController extends Controller
{
    public function index(Request $request){
        $token = $request->header('token');
        $checkToken = SessionUser::where('token', $token)->first();
        if(!empty($checkToken)){
            return response()->json([
                'code' => 200,
                'data' => Post::all(),
            ], 200); 
        }else{
            return response()->json([
                'code' => 401,
                'message' => 'token không đúng',
            ], 401); 
        }
        
    }
}

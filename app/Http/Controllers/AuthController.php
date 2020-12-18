<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    public function auth_with_facebook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|min:4|max:25',
            'name' => 'string|required|min:4|max:25',
            'profile_pic_link' => 'string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),404);
        } else {
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'addr' => '',
                    'profile_pic_link' => $request->profile_pic_link,
                ]);
                $is_saved = $user->save();
                if ($is_saved) {
                    return response(['user' => $user, 'token' => $user->createToken('my-app-token')->plainTextToken], 201);
                } else {
                    return http_response_code(404);
                }
            }else {
                $query = DB::update('update users set full_name=?, profile_pic_link=? where username = ?', [$request->name,$request->profile_pic_link,$request->username]);
                return response(['user' => $user, 'token' => $user->createToken('my-app-token')->plainTextToken], 201);
            }
        }
    }
}

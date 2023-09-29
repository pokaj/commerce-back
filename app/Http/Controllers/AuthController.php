<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function signUp(Request $request): array
    {
        $this->validate($request, [
            'username' => 'required|unique:users|min:3|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
        ]);

        $cleanData = [
            'username' => strip_tags($request['username']),
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ];
        $user = User::create($cleanData);
        return ['code' => 0, 'desc' => 'successful', 'data' => $user];
    }


    /**
     * @throws ValidationException
     */
    public function login(Request $request): array
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request['email'])->first();
        if ($user){
            if(Hash::check($request['password'], $user['password'])){
                return ['code' => 0, 'desc' => 'successful', 'data' => $user];
            }else{
                return ['code' => 1, 'desc' => 'unsuccessful', 'msg' => 'incorrect credentials'];
            }
        }else{
            return ['code' => 1, 'desc' => 'unsuccessful', 'msg' => 'incorrect credentials'];
        }
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class ApiTokenController extends Controller
{
    /**
     * Updates the user token for login
     *
     * @param Request $req
     * @return array
     */
    public function update(Request $req) {
        $token = JWTAuth::fromUser($req->user());

        $req->user()->forceFill([
            'api_token' => $token,
        ])->save();

        return ['token' => $token];
    }

    /**
     * Sign in function
     *
     * @param Request $req
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function signIn(Request $req){
        $req->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if(Auth::attempt($req->only('email', 'password'))) {
            return $this->update($req);
        }else {
            return response("User not recognized", 401);
        }
    }
}

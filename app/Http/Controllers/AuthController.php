<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param StoreUserRequest $request
     * 
     * @return User
     */
    public function register(StoreUserRequest $request)
    {

        $user = User::create($request->all());
        // I have to create a user resource file
        return response()->json([
            'data' => $user,
            'accessToken' => $user->createToken('api_token')->plainTextToken,
            'tokenType' => 'Bearer'
        ], 201);
    }

    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        // // verify if the user exist using the auth facade to check if we can sign in
        // if(! Auth::attempt($validated) ){
        //     // if fails
        //     return response()->json([
        //         'message' => 'login information invalid'
        //     ], 401);
        // }

        // get user information
        $user = User::where('email', $validated['email'])->first();
        if ($user) {
            return response()->json([
                'message' => 'login successfull'
            ], 200);
        } else {
            return response()->json([
                'message' => 'email or password invalid'
            ], 400);
        }

        return response()->json([
            // 'accessToken' => $user->createToken('api_token')->plainTextToken,
            // 'tokenType' => 'Bearer'
            'message' => 'login successfull'
        ], 201);
    }
}

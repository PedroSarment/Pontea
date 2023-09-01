<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Register the user.
     *
     * @bodyParam   name   string  required    The name of the  user.   Example: secret
     * @bodyParam   email    string  required    The email of the  user.      Example: testuser@example.com
     * @bodyParam   password    string  required    The password of the  user.   Example: secret
     * @bodyParam   password_confirmation string  required    The password of the  user password.  Example: secret
     *
     * @response {
     *  'message' => 'User created successfully',
     * }
    */
    public function register(Request $request)
    {
        $campos = $request->all();

        Validator::make($campos, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()
            ->json(['message' => 'User created successfully']);
    }

    /**
     * Log in the user.
     *
     * @bodyParam   name   string  required    The name of the  user.   Example: secret
     * @bodyParam   email    string  required    The email of the  user.      Example: testuser@example.com
     * @bodyParam   password    string  required    The password of the  user.   Example: secret
     * @bodyParam   password_confirmation string  required    The password of the  user password.  Example: secret
     *
     * @response {
     *  'message' => 'User created successfully',
     * }
    */
    public function login(Request $request)
    {
        $campos = $request->all();

        Validator::make($campos, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])->validate();

        $user = User::where('email', '=', $campos['email'])->get()->first();

        if(!$user){

            return response()
            ->json(['message' => 'We could not find a user with that email']);
        }

        if (!Hash::check($campos['password'], $user->password)) {

            return response()
            ->json(['message' => 'Incorrect password']);
        }

        $auth = Auth::create([
            'user_id' => $user->id,
            'token' => Hash::make(Str::random(10)),
        ]);

        return response()
        ->json(['message' => 'User successfully logged in',
                'token' => $auth->token
            ]);
    }



}

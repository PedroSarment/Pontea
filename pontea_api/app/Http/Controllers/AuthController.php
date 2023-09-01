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
     * Register a new user.
     *
     * @group Authentication
     *
     * Creates a new user with the provided information.
     *
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email address of the user. Example: john@example.com
     * @bodyParam password string required The password for the user. Example: secret
     * @bodyParam password_confirmation string required The confirmation of the user's password. Example: secret
     *
     * @response 201 {
     *     "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "created_at": "2023-09-01T12:34:56Z",
     *         "updated_at": "2023-09-01T12:34:56Z"
     *     },
     *     "message": "User created successfully"
     * }
     *
     * @response 422 {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "email": ["The email has already been taken."]
     *     }
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
            'credit' => 0
        ]);

        return response()
            ->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Log in the user.
     *
     * @group Authentication
     *
     * @bodyParam email string required The email of the user. Example: testuser@example.com
     * @bodyParam password string required The password of the user. Example: secret
     *
     * @response {
     *     "message": "User successfully logged in",
     *     "token": "generated_token_here"
     * }
     *
     * @response 422 {
     *     "message": "We could not find a user with that email"
     * }
     *
     * @response 422 {
     *     "message": "Incorrect password"
     * }
    */
    public function login(Request $request)
    {
        $campos = $request->all();

        Validator::make($campos, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
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
            ], 201);
    }



}

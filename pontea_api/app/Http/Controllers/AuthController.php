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
use App\Models\purchase;
use App\Models\Activity;

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


        /**
     * Get the profile information for the authenticated user.
     *
     * This endpoint retrieves detailed information about the authenticated user, including their purchased activities, activities created by them,
     * average rating, and count of ratings for their created activities.
     *
     * @authenticated
     *
     *
     * @group Authentication
     *
     * @header Authorization Bearer $2y$10$mhuGD2BQ6WZYTZcpPxwTHOIj/aQlmgG9ahXn66BZQ.GBmbGB7gggi
     *
     * @response 200 {
     *     "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "created_at": "2023-09-01T12:34:56Z",
     *         "updated_at": "2023-09-01T12:34:56Z"
     *     },
     *     "purchased_activities": [
     *         {
     *             "id": 1,
     *             "title": "Activity 1",
     *             "description": "Description of Activity 1",
     *             "price": 10.99,
     *             "created_at": "2023-09-02T14:45:00Z",
     *             "updated_at": "2023-09-02T14:45:00Z"
     *         },
     *         {
     *             "id": 2,
     *             "title": "Activity 2",
     *             "description": "Description of Activity 2",
     *             "price": 12.99,
     *             "created_at": "2023-09-03T10:30:00Z",
     *             "updated_at": "2023-09-03T10:30:00Z"
     *         }
     *     ],
     *     "created_activities": [
     *         {
     *             "id": 3,
     *             "title": "My Created Activity 1",
     *             "description": "Description of My Created Activity 1",
     *             "price": 8.99,
     *             "created_at": "2023-09-04T09:15:00Z",
     *             "updated_at": "2023-09-04T09:15:00Z"
     *         }
     *     ]
     * }
     */
    public function profile()
    {
        $user = session('user'); // Assuming the user is already logged in via session.

        $purchases = purchase::where('bought_by', $user->id)->get();

        $activities = [];

        if($purchases) {

            foreach($purchases as $purchase) {
                $activity = Activity::find($purchase->activity_id);

                if($activity)
                {
                    $activities[] = $activity;
                }


            }

            $purchasedActivities = $activities;
        } else {

            $purchasedActivities = null;
        }

        // Retrieve activities created by the user.
        $createdActivities = $user->createdActivities;

        // Calculate average rating and count of ratings for created activities.
        $averageRating = $createdActivities->avg('average_rating');
        $ratingCount = $createdActivities->sum('rating_count');

        // Construct the user profile response.
        $profileData = [
            'user' => $user,
            'purchased_activities' => $purchasedActivities,
            'created_activities' => $createdActivities,
            'sales_history'=> $this->getSalesHistory($user)

        ];

        return response()->json($profileData);
    }

    private function getSalesHistory(User $teacher)
    {
        $history = [];

        if($teacher->createdActivities) {

            foreach($teacher->createdActivities as $activity) {

                $purchases = purchase::where('activity_id', $activity->id)->get();

                if($purchases != null) {

                    foreach($purchases as $purchase) {

                        $purchase->user = User::find($purchase->bought_by);
                        $purchase->activity = Activity::find($purchase->activity_id);

                        $history[] = $purchase;
                    }
                }
            }
        }

        return $history;
    }

}

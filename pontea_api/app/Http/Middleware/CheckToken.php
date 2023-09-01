<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Auth;
use App\Models\User;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if($token != ''){

            $auths = Auth::where(['token' => $token, 'deleted_at' => ''])->get();

            if($auths){

                $user = User::find($auths[0]->user_id);

                $request->session()->put('user', $user);

                return $next($request);
            } else {

                return response()
                ->json(['message' => 'Invalid token']);
            }

        } else {

            return response()
            ->json(['message' => 'Request without token']);
        }
    }
}

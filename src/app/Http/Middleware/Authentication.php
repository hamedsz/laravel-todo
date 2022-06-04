<?php

namespace TodoApp\app\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use TodoApp\app\Models\User;

class Authentication
{
    public function handle($request, Closure $next){
        $token = $request->header('Authorization');
        $token = Str::replaceFirst('Bearer ', '', $token);

        try {
            $data = decrypt($token);
        }
        catch (DecryptException $exception){
            abort(401);
        }

        $userId = @$data['id'];
        $user = User::find($userId);
        if (!$user){
            abort(401);
        }

        auth()->login($user);
        return $next($request);
    }
}

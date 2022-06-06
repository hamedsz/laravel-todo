<?php

namespace TodoApp\app\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use TodoApp\app\Models\User;

class UserService implements UserInterface
{
    public function findByEmail(string $email) : User{
        return User::query()
            ->where('email', $email)
            ->firstOrFail();
    }

    public function getToken(User $user) : string{
        return $user->getAuthToken();
    }

    public function login(string $email, $password) : array{
        $user = $this->findByEmail($email);

        if (!Hash::check($password, $user->password)){
            throw ValidationException::withMessages([
                'login' => 'incorrect username or password'
            ]);
        }

        return [
            'user' => $user,
            'token' => $this->getToken($user)
        ];
    }
}

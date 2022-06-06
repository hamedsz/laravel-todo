<?php

namespace TodoApp\app\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use TodoApp\app\Models\User;

class UserService implements UserInterface
{
    public function findByEmail(string $email, bool $kill=true) : ?User{
        $user = User::query()
            ->where('email', $email);

        return $kill ? $user->firstOrFail() : $user->first();
    }

    public function getToken(User $user) : string{
        return $user->getAuthToken();
    }

    public function login(string $email, $password) : array{
        $user = $this->findByEmail($email, false);

        if (!$user || !Hash::check($password, $user->password)){
            throw ValidationException::withMessages([
                'login' => 'incorrect username or password'
            ]);
        }

        return $this->authResponse($user);
    }
    public function make(array $data) : User{
        return new User($data);
    }

    public function authResponse(User $user){
        return [
            'user' => $user,
            'token' => $this->getToken($user)
        ];
    }

    public function signup(string $email, string $password, array $data=[]) : array{
        $isEmailExists = $this->findByEmail($email, false);

        if ($isEmailExists){
            throw ValidationException::withMessages([
                'email' => 'email is used before'
            ]);
        }

        $user = $this->make($data);
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();

        return $this->authResponse($user);
    }
}

<?php

namespace TodoApp\Tests\Feature;

use TodoApp\Tests\TestCase;

class SignupTest extends TestCase
{
    public function testSignup(){
        $response = $this->json('POST', '/api/v1/todo/auth/signup', [
            'name' => 'TEST',
            'email' => 'example@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'email' => 'example@mail.com'
                ]
            ]);
    }

    public function testSignupIncorrectConfirmation(){
        $response = $this->json('POST', '/api/v1/todo/auth/signup', [
            'name' => 'TEST',
            'email' => 'example@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password2',
        ]);

        $response->assertStatus(422);
    }

    public function testSignupDuplicateEmail(){
        $user = $this->createFakeUser();

        $response = $this->json('POST', '/api/v1/todo/auth/signup', [
            'name' => 'TEST',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422);
    }
}

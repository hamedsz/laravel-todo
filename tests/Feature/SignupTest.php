<?php

namespace TodoApp\Tests\Feature;

use TodoApp\Tests\TestCase;

class SignupTest extends TestCase
{
    public function testSignup(){
        $response = $this->json('POST', '/api/v1/todo/auth/signup', [
            'email' => 'example@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(204)
            ->assertJson([
                'user' => [
                    'email' => 'example@mail.com'
                ]
            ]);
    }
}

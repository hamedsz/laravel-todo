<?php

namespace TodoApp\Tests\Feature;

use TodoApp\Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogin(){
        $this->withoutExceptionHandling();
        $user = $this->createFakeUser();

        $response = $this->json('POST', '/api/v1/todo/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200)
        ->assertJson([
            'user' => $user->toArray()
        ]);
    }

    public function testLoginFailed(){
        $user = $this->createFakeUser();

        $response = $this->json('POST', '/api/v1/todo/auth/login', [
            'email' => $user->email,
            'password' => 'abcd',
        ]);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/v1/todo/auth/login', [
            'email' => 'adwa@mail.com',
            'password' => 'password',
        ]);
        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @test
     * Test Registration
     */
    public function testRegister()
    {
        // User's data
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234'
        ];

        // Send Post request
        $response = $this->json('POST', route('api.register'), $data);
        // Assert the request was successful
        $response->assertStatus(200);
        // Assert we received a token
        $this->assertArrayHasKey('token', $response->json());
        // Delete data
        User::where('email', 'test@gmail.com')->delete();
    }

    /** 
     * @test
     * Test Login
     * */
    public function testLogin()
    {
        // Create User
        User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        // attempt login
        $response = $this->json('POST', route('api.authenticate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234'
        ]);

        // Assert it was successful and a token was received
        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
        User::where('email', 'test@gmail.com')->delete();
    }
}

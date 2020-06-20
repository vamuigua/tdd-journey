<?php

namespace Tests\Feature;

use App\Recipe;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /**
     * Create user and generate token
     *
     * @return token
     */
    public function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234')
        ]);
        $this->user = $user;
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    /**
     * Test Creating a new Recipe
     * @return void
     */
    public function testCreate()
    {
        // Get Token
        $token = $this->authenticate();

        // Create a new Recipe
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', route('recipe.create'), [
            'title' => 'Jollof Rice',
            'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
        ]);

        //Assert response status of 200 
        $response->assertStatus(200);

        // Get count and assert
        $count = User::where('email', 'test@gmail.com')->first()->recipes()->count();
        $this->assertEquals(1, $count);
    }

    /**
     * Test the all route 
     * @return void
     */
    public function testAll()
    {
        // Authenticate and attach recipe to user
        $token = $this->authenticate();
        $recipe = Recipe::create([
            'title' => 'Jollof Rice',
            'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
        ]);
        $this->user->recipes()->save($recipe);

        // call the route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('GET', route('recipe.all'));
        $response->assertStatus(200);

        // Assert the count is 1 and the title of the first item correlates
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals('Jollof Rice', $response->json()[0]['title']);
    }

    /**
     * Test the Update route
     * @return void
     */
    public function testUpdate()
    {
        // Authenticate and attach recipe to user
        $token = $this->authenticate();
        $recipe = Recipe::create([
            'title' => 'Jollof Rice',
            'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
        ]);
        $this->user->recipes()->save($recipe);

        // call route and assert respose
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', route('recipe.update', ['recipe' => $recipe->id]), [
            'title' => 'Rice'
        ]);
        $response->assertStatus(200);

        // Assert title is this new title
        $this->assertEquals('Rice', $this->user->recipes()->first()->title);
    }

    /**
     * Test the single show route
     * @return void
     */
    public function testShow()
    {
        // Authenticate and attach recipe to user
        $token = $this->authenticate();
        $recipe = Recipe::create([
            'title' => 'Jollof Rice',
            'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
        ]);
        $this->user->recipes()->save($recipe);

        // call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('GET', route('recipe.show', ['recipe' => $recipe->id]));
        $response->assertStatus(200);

        // Assert title is correct
        $this->assertEquals('Jollof Rice', $response->json()['title']);
    }

    /**
     * Test the delete route
     * @return void
     */
    public function testDelete()
    {
        // Authenticate and attach recipe to user
        $token = $this->authenticate();
        $recipe = Recipe::create([
            'title' => 'Jollof Rice',
            'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
        ]);
        $this->user->recipes()->save($recipe);

        // call route and assert response
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->json('POST', route('recipe.delete', ['recipe' => $recipe->id]));
        $response->assertStatus(200);

        // Assert there are no recipes
        $this->assertEquals(0, $this->user->recipes()->count());
    }
}

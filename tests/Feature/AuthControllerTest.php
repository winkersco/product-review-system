<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $userData = [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('auth.register'), $userData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'User registered successfully.',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
        ]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function testUserLogin()
    {
        $user = User::factory()->create([
            'name' => 'johndoe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginData = [
            'username' => 'johndoe',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('auth.login'), $loginData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }

    /**
     * Test fetching user details.
     *
     * @return void
     */
    public function testFetchUserDetails()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('auth.me'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'User fetched successfully.',
                'data' => [
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                ],
            ]);
    }

        /**
     * Test user logout.
     *
     * @return void
     */
    public function testUserLogout()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->postJson(route('auth.logout'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'User logged out successfully.',
            ]);
    }

    /**
     * Test token refresh.
     *
     * @return void
     */
    public function testTokenRefresh()
    {
        $user = User::factory()->create();

        $response = $this->actingAsUser($user)->postJson(route('auth.refresh'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}

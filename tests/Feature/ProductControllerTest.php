<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method of ProductController.
     *
     * @return void
     */
    public function testProductIndex()
    {
        $user = User::factory()->create();
        Product::factory()->count(3)->create();

        $response = $this->actingAsUser($user)->getJson(route('products.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'comments' => [
                            '*' => [
                                'id',
                                'comment',
                            ],
                        ]
                    ],
                ],
            ]);
    }

    /**
     * Test the store method of ProductController.
     *
     * @return void
     */
    public function testProductStore()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test Product',
        ];

        $response = $this->actingAsUser($user)->postJson(route('products.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }
}

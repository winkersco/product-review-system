<?php

namespace Tests\Feature;

use App\Factories\AppendFileOperationFactory;
use App\Factories\ReplaceFileOperationFactory;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the store method of CommentController.
     *
     * @return void
     */
    public function testCommentStore()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Comment::factory()->count(1)->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $data = [
            'product_name' => $product->name,
            'comment' => 'Test comment',
        ];

        $response = $this->actingAsUser($user)
            ->postJson(route('comments.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'comment',
                    'user',
                    'product',
                ],
            ]);

        $this->assertDatabaseHas('comments', [
            'comment' => 'Test comment',
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /**
     * Test the store method of CommentController.
     *
     * @return void
     */
    public function testCommentStoreLimit()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Comment::factory()->count(2)->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $data = [
            'product_name' => $product->name,
            'comment' => 'Test comment',
        ];

        $response = $this->actingAsUser($user)
            ->postJson(route('comments.store'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJson([
                'message' => 'You have reached the maximum limit of comments for this product.',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('comments', [
            'comment' => 'Test comment',
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}

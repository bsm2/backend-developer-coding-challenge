<?php

namespace Tests\Feature\Client;

use App\Models\BuyingInvoice;
use App\Models\Cart;
use App\Models\Destination;
use App\Models\Item;
use App\Models\Mosque;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->userAuth();
    }

    /**
     * A basic feature test example.
     */
    public function test_user_should_login_to_add_to_post(): void
    {
        $response = $this->postJson('/api/posts', []);

        $response->assertStatus(401)->assertJson(
            fn(AssertableJson $json) =>
            $json->has('message')->where('message', __('Unauthenticated.'))->etc()
        );
    }

    public function test_title_is_required_to_add_post(): void
    {
        $response = $this->actingAs($this->user)->postJson('api/posts', []);

        $response->assertStatus(422)->assertJson(
            fn(AssertableJson $json) =>
            $json->has('error')->has('data')
                ->where(
                    'data.title.0',
                    __('validation.required', ['attribute' => 'title'])
                )->etc()
        );
    }

    public function test_content_is_required_to_add_post(): void
    {
        $response = $this->actingAs($this->user)->postJson('api/posts', []);

        $response->assertStatus(422)->assertJson(
            fn(AssertableJson $json) =>
            $json->has('error')->has('data')
                ->where(
                    'data.content.0',
                    __('validation.required', ['attribute' => 'content'])
                )->etc()
        );
    }
}

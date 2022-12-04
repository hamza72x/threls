<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_add_item()
    {
        // upload product first
        $seller = $this->upload_products();
        $buyer = User::factory()->create(['account_type' => User::ACCOUNT_TYPE_BUYER]);

        $product = $seller->products()->first();

        $response = $this->actingAs($buyer)->post("/cart/{$product->id}/add", []);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Product added to cart');
    }

    public function test_cart_remove_item()
    {
        // upload product first
        $seller = $this->upload_products();
        $buyer = User::factory()->create(['account_type' => User::ACCOUNT_TYPE_BUYER]);

        $product = $seller->products()->first();

        $response = $this->actingAs($buyer)->post("/cart/{$product->id}/add", []);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Product added to cart');

        // remove product from cart
        $response = $this->actingAs($buyer)->post("/cart/{$product->id}/remove", []);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Product removed from cart');
    }

    public function test_increase_quantity()
    {
        $seller = $this->upload_products();
        $buyer = User::factory()->create(['account_type' => User::ACCOUNT_TYPE_BUYER]);

        $product = $seller->products()->first();

        $response = $this->actingAs($buyer)->post("/cart/{$product->id}/add", []);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Product added to cart');

        // increase quantity
        $response = $this->actingAs($buyer)->post("/cart/{$product->id}/add", []);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Product added to cart');

        // check quantity
        $this->assertEquals(2, $buyer->mainCart()->cartItems()->first()->quantity);
    }

    private function upload_products()
    {
        // upload product first
        $seller = User::factory()->create(['account_type' => User::ACCOUNT_TYPE_SELLER]);

        Storage::fake('uploads');

        $header = 'Product Name,Brand,Price';
        $row1 = 'Product 1,Medicine Schmedicine,€51';
        $row2 = 'Product 2,Medicine Schmedicine,€258';

        $content = implode("\n", [$header, $row1, $row2]);

        $response = $this->actingAs($seller)->post('/products/import', [
            'file' => UploadedFile::fake()->createWithContent('fake.csv', $content)
        ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Import is in progress, refresh after a while');

        return $seller;
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_bulk_import()
    {
        $user = User::factory()->create(['account_type' => User::ACCOUNT_TYPE_SELLER]);

        Storage::fake('uploads');

        $header = 'Product Name,Brand,Price';
        $row1 = 'Product 1,Medicine Schmedicine,€51';
        $row2 = 'Product 2,Medicine Schmedicine,€258';

        $content = implode("\n", [$header, $row1, $row2]);


        $response = $this->actingAs($user)->post('/products/import', [
            'file' => UploadedFile::fake()->createWithContent('fake.csv', $content)
        ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHas('status', 'Import is in progress, refresh after a while');
    }

}

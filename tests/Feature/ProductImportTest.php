<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\ImportProductsJob;

class ProductImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_product_csv_and_dispatch_job()
    {
        Queue::fake();
        Storage::fake('local');

        $admin = Admin::first();

        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Test Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
            ]);
        }


        $csvContent = <<<CSV
name,price,category,stock
Phone,10000,Electronics,5
Laptop,50000,Electronics,2
CSV;

        $file = UploadedFile::fake()->createWithContent(
            'products.csv',
            $csvContent
        );

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.products.import.store'), [
                'file' => $file,
            ]);

        $response->assertRedirect(route('admin.products.index'));

        Queue::assertPushed(ImportProductsJob::class);
    }
}

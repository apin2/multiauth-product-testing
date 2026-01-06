<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\ImportProductsJob;

class ImportProductsJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_job_creates_products_from_csv()
    {
        Storage::fake('local');

        $csvContent = <<<CSV
name,price,category,stock
Tablet,15000,Electronics,3
CSV;

        $filePath = 'temp/test_products.csv';
        Storage::put($filePath, $csvContent);

        $job = new ImportProductsJob(
            $filePath,
            'products/default-product.svg'
        );

        $job->handle();

        $this->assertDatabaseHas('products', [
            'name' => 'Tablet',
            'price' => 15000,
            'category' => 'Electronics',
            'stock' => 3,
        ]);
    }
}

<?php
namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $path) {}

    public function handle(): void
    {
        $filePath = Storage::path($this->path);
        $handle = fopen($filePath, 'r');

        $header = fgetcsv($handle); // first row
        $batch = [];
        $batchSize = 1000;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            // Skip invalid rows
            if (empty($data['name']) || empty($data['price'])) {
                continue;
            }

            $batch[] = [
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'price'       => (int) $data['price'], // integer price
                'category'    => $data['category'] ?? null,
                'stock'       => (int) ($data['stock'] ?? 0),
                'image'       => $data['image'] ?? 'products/default-product.svg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            if (count($batch) >= $batchSize) {
                Product::insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            Product::insert($batch);
        }

        fclose($handle);
        Storage::delete($this->path);
    }
}

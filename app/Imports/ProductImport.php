<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;



class ProductImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected $defaultImage;
    
    public function __construct($defaultImage)
    {
        $this->defaultImage = $defaultImage;
    }

    public function model(array $row)
    {
        $productData = [
            'name' => isset($row['name']) ? trim($row['name']) : '',
            'description' => isset($row['description']) ? trim($row['description']) : '',
            'price' => isset($row['price']) ? (float) $row['price'] : 0,
            'image' => isset($row['image']) ? trim($row['image']) : null,
            'category' => isset($row['category']) ? trim($row['category']) : '',
            'stock' => isset($row['stock']) ? (int) $row['stock'] : 0,
        ];
        
        if (empty($productData['image']) || $productData['image'] === 'NULL' || $productData['image'] === 'null' || $productData['image'] === 'NULL' || $productData['image'] === 'Null') {
            $productData['image'] = $this->defaultImage;
        } else {
            if ($this->isValidImage($productData['image'])) {
                $imagePath = $productData['image'];
                $filename = basename($imagePath);
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $newFilename = Str::random(40) . '.' . $extension;
                $storagePath = 'products/' . $newFilename;
                
                $fileContents = file_get_contents(public_path($productData['image']));
                Storage::disk('public')->put($storagePath, $fileContents);
                $productData['image'] = $storagePath;
            } else {
                $productData['image'] = $this->defaultImage;
            }
        }
        
        return new Product($productData);
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
    
    private function isValidImage($imagePath): bool
    {
        if (file_exists(public_path($imagePath))) {
            $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];
            
            return in_array($extension, $validExtensions);
        }
        
        return false;
    }
}
<?php

namespace App\Jobs;

use App\Imports\ProductImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $defaultImage;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $defaultImage = null)
    {
        $this->filePath = $filePath;
        $this->defaultImage = $defaultImage;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $fullPath = Storage::path($this->filePath);            
            \Maatwebsite\Excel\Facades\Excel::import(new ProductImport($this->defaultImage), $fullPath);
        } finally {
            Storage::delete($this->filePath);
        }
    }
}

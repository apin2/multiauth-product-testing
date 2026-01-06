<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ImportProductsJob;
use Illuminate\Support\Facades\Storage;

class ProductImportController extends Controller
{
    // Show import page
    public function create()
    {
        return view('admin.products.import');
    }

    // Handle CSV upload
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:20480', // 20MB
        ]);

        $path = $request->file('file')->store('imports');

        ImportProductsJob::dispatch($path);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'CSV import started. Products will be imported in background.');
    }
}

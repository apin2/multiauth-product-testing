<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductsRequest;
use App\Jobs\ImportProductsJob;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'price'    => 'required|numeric',
            'category' => 'required|string',
            'stock'    => 'required|integer',
            'image'    => 'nullable|image|max:2048',
        ]);

        $imagePath = 'products/default-product.svg';

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category'    => $request->category,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'     => 'required|string',
            'price'    => 'required|numeric',
            'category' => 'required|string',
            'stock'    => 'required|integer',
            'image'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && $product->image !== 'products/default-product.svg') {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')
                ->store('products', 'public');
        }

        $product->update($request->only([
            'name',
            'description',
            'price',
            'category',
            'stock',
        ]));

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        if ($product->image && $product->image !== 'products/default-product.svg') {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function showImportForm()
    {
        return view('admin.products.import');
    }

    public function import(ImportProductsRequest $request)
    {
        try {
            $file = $request->file('file');
            $fileName = 'temp/' . Str::random(40) . '.' . $file->getClientOriginalExtension();

            Storage::put($fileName, file_get_contents($file));
            $defaultImage = 'products/default-product.svg';
            ImportProductsJob::dispatch($fileName, $defaultImage);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product import started successfully. The products will be imported in the background.');
        } catch (\Exception $e) {
            if (isset($fileName) && Storage::exists($fileName)) {
                Storage::delete($fileName);
            }
            
            return redirect()
                ->route('admin.products.import')
                ->with('error', 'An error occurred while starting the import: ' . $e->getMessage());
        }
    }
}

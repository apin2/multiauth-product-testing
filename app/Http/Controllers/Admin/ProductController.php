<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query();
        
        // Handle search
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('description', 'LIKE', "%$search%")
                  ->orWhere('category', 'LIKE', "%$search%");
            });
        }
        
        $perPage = request('perPage', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;
        
        $products = $query->latest()->paginate($perPage);
        
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

}
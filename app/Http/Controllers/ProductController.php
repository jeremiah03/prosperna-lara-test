<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Show the product dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.product-dashboard');
    }

    /**
     * Get products.
     *
     * @return \App\Models\Product
     */
    public function data()
    {
        return Product::with('category')->get();
    }

    /**
     * Show product create page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.product-create', [
            'categories' => $categories
        ]);
    }

    /**
     * Create new product.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = null;
        if ($request->hasFile('img_thumbnail')) {
            $file = $request->file('img_thumbnail');
            $filename = $file->store('public');
        }
        $data = $request->except('_token', '_method');
        $data['img_thumbnail'] = str_replace('public/', '', $filename);;

        Product::create($data);

        return redirect()->route('product.index')
            ->with([
                'status' => 'success',
                'message' => 'Product successfully added!'
            ]);
    }

    /**
     * Show product preview page.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Product $product)
    {
        return view('pages.product-preview', [
            'product' => $product
        ]);
    }

    /**
     * Show product edit page.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('pages.product-create', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $filename = null;
        if ($request->hasFile('img_thumbnail')) {
            $file = $request->file('img_thumbnail');
            $filename = $file->store('public');

            //Delete img
            Storage::disk('public')->delete($product->img_thumbnail);
        }

        $data = $request->except('_token', '_method');
        $data['img_thumbnail'] = str_replace('public/', '', $filename);

        $product->fill($data)->update();

        return redirect()->route('product.index')
            ->with([
                'status' => 'success',
                'message' => 'Product successfully updated!'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

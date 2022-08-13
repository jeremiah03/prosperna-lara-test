<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.product-dashboard');
    }

    public function data()
    {
        return Product::with('category')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.product-create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $filename = null;
        if ($request->hasFile('img_thumbnail')) {
            $file = $request->file('img_thumbnail');
            $filename = $file->store('public');
        }
        $data = $request->except('_token', '_method');
        $data['img_thumbnail'] = str_replace('public/', '', $filename);;

        // return $data;

        Product::create($data);

        return redirect()->route('product.index')
            ->with([
                'status' => 'success',
                'message' => 'Product successfully added!'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return view('pages.product-preview', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
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

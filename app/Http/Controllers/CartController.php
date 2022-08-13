<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = auth()->user()->cart;
        // return $cart;
        return view('pages.cart', ['cart' => $cart]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart_item = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->first();

        if (!$cart_item) {
            Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
            ]);
        } else {
            $cart_item->quantity += $request->quantity ?? 1;
            $cart_item->save();
        }

        return redirect()->back();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'cart item added',
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'cart item updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'cart item removed'
        ]);
    }
}

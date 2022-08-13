<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CheckOut;
use App\Models\CheckOutProduct;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->cart) {
            return redirect()->route('home');
        }

        $cart = Cart::with('product')->whereIn('id', explode(',', $request->cart))->get();

        // return $cart;
        return view('pages.checkout', [
            'cart' => $cart
        ]);
    }

    public function checkout(Request $request)
    {
        // return $request->all();
        $cart = Cart::with('product')->whereIn('id', $request->item)->get();
        $sum = 0;
        foreach ($cart as $item) {
            $sum += $item->quantity * $item->product->price;
        }

        $checkout = CheckOut::create([
            'user_id' => auth()->user()->id,
            'address' => $request->address,
            'address2' => $request->address2 ?? null,
            'country' => $request->country,
            'zip' => $request->zip,
            'payment_method' => $request->payment_method,
            'total_amount' => $sum,
        ]);


        foreach ($cart as $item) {
            CheckOutProduct::create([
                'check_out_id' => $checkout->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'amount' => $item->product->price
            ]);

            $item->delete();
        }


        return redirect()->route('checkout.complete');
    }

    public function complete()
    {
        return view('pages.checkout-complete');
    }
}

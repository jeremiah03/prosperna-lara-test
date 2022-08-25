<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CheckOut;
use App\Models\CheckOutProduct;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the checkout page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$request->cart) {
            return redirect()->route('home');
        }

        $cart = Cart::with('product')->whereIn('id', explode(',', $request->cart))->get();

        return view('pages.checkout', [
            'cart' => $cart
        ]);
    }

    public function checkout(Request $request)
    {
        $cart = Cart::with('product')->whereIn('id', $request->item)->get();
        $sum = 0;


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
            $sum += $item->quantity * $item->product->price;

            CheckOutProduct::create([
                'check_out_id' => $checkout->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'amount' => $item->product->price
            ]);

            $item->delete();
        }

        $checkout->total_amount = $sum;
        $checkout->save();

        return redirect()->route('checkout.complete');
    }

    public function complete()
    {
        return view('pages.checkout-complete');
    }
}

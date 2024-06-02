<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Carts;

class ProductsController extends Controller
{
    // Show the index page
    public function index()
    {
        $products = Products::all();
        $totalItems = $this->getTotalItems();

        return view('products.index', compact('products', 'totalItems'));
    }

    // cart view
    public function cart()
    {
        $user_id = auth()->id();
        $cartItems = Carts::where('user_id', $user_id)->with('product')->get();
        $totalItems = $this->getTotalItems();
        $totalPrice = $this->getTotalPrice();

        return view('products.cart', compact('cartItems', 'totalItems', 'totalPrice'));
    }

    // function to add product to cart
    public function addCart($id)
    {
        $user_id = auth()->id();

        $cart = Carts::where('user_id', $user_id)
                    ->where('product_id', $id)
                    ->first();

        if($cart) {
            $cart->quantity++;
            $cart->save();
        }else{
            Carts::create ([
                'user_id' => $user_id,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return response()->json([
            'success' => 'Product added to cart!',
            'totalItems' => $this->getTotalItems()
        ]);
    }

    // function to delete product from cart
    public function deleteCart(Request $request)
    {
        if ($request->id) {
            $user_id = auth()->id();
            Carts::where('user_id', $user_id)
                ->where('product_id', $request->id)
                ->delete();
        }
        return redirect()->back()->with('success', 'Product successfully deleted!');
    }

    // Function to get total items in cart
    private function getTotalItems()
    {
        $user_id = auth()->id();
        return Carts::where('user_id', $user_id)->sum('quantity');
    }

    // Function to get total price in cart
    private function getTotalPrice()
    {
        $user_id = auth()->id();
        $cartItems = Carts::where('user_id', $user_id)->with('product')->get();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }
        return $totalPrice;
    }

}
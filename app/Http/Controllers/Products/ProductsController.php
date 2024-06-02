<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    // Show the index page
    public function index()
    {
        $products = Products::all();
        return view('products.index', compact('products'));
    }

    // cart view
    public function cart()
    {
        return view('products.cart');
    }

    // function to add product to cart
    public function addCart($id)
    {
        $products = Products::findOrFail($id);
        $cart = session()->get('cart', []);
        // condition isset
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }else{
            $cart[$id] = [
                "name" => $products->name,
                "quantity" => 1,
                "price" => $products->price,
                "image" => $products->image,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product ditambahkan ke kerangjang!');
    }

    // function to update cart
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            // set session
            session()->put('cart', $cart);
            session()->flash('success', 'Product ditambahkan ke keranjang.');
        }
    }

    // function to delete product in from cart
    public function deleteCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            // set session
            session()->flash('success', 'Product berhasil dihapus.');
        }
    }

}
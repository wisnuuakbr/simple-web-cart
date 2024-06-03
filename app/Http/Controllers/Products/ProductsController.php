<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Carts;
use App\Models\User;

class ProductsController extends Controller
{
    // Show the index page
    public function index()
    {
        $products = Products::paginate(24);
        $totalItems = $this->getTotalItems();

        return view('products.index', compact('products', 'totalItems'));
    }

    // Cart page
    public function cart()
    {
        $user_id = auth()->id();
        $cartItems = Carts::where('user_id', $user_id)->with('product')->get();
        $totalItems = $this->getTotalItems();
        $totalPrice = $this->getTotalPrice();
        // Get coupon
        $couponEarned = $this->generateCoupon($user_id);

        return view('products.cart', compact('cartItems', 'totalItems', 'totalPrice', 'couponEarned'));
    }

    // Function to add product to cart
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

    // Function to delete product from cart
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

    // Checkout page
    public function checkout()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);

        $cartItems = Carts::where('user_id', $user_id)->with('product')->get();
        $totalItems = $this->getTotalItems();
        $totalPrice = $this->getTotalPrice();
        // Get total coupons earned
        $totalCouponsEarned = $this->generateCoupons($cartItems, $totalPrice);

        return view('products.checkout', compact('cartItems', 'totalItems', 'totalPrice', 'totalCouponsEarned', 'user'));
    }

    // Function generate coupon per item
    private function generateCoupon($user_id)
    {
        $cartItems = Carts::where('user_id', $user_id)->with('product')->get();
        $coupons = [];
        foreach ($cartItems as $item) {
            if ($item->product->price > 50000) {
                $coupons[$item->product_id] = $item->quantity;
            } else {
                $coupons[$item->product_id] = 0;
            }
        }
        return $coupons;
    }

    // Generate Total Coupons
    private function generateCoupons($cartItems, $totalPrice)
    {
        $totalCouponsFromPrice = 0;
        foreach ($cartItems as $item) {
            if ($item->product->price > 50000) {
                $totalCouponsFromPrice += $item->quantity;
            }
        }

        // Calculate total coupons based on total purchase (every 100000 gets 1 coupon)
        $totalCouponsFromTotalPurchase = floor($totalPrice / 100000);

        // Total coupons earned
        $totalCouponsEarned = $totalCouponsFromPrice + $totalCouponsFromTotalPurchase;

        return $totalCouponsEarned;
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
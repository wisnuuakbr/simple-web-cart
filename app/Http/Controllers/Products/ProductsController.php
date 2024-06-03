<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Carts;
use App\Models\User;
use App\Models\History;

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
        // Cek cart condition
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
        // Get coupon per item
        $couponPerItem = $this->generateCoupon($user_id);
        // Get coupon per purchase
        $couponPerPurchase = $this->generateTotalCoupons($totalPrice);
        // Total coupon
        $totalCouponsEarned = array_sum($couponPerItem) + $couponPerPurchase;

        return view('products.checkout', compact('cartItems', 'totalItems', 'totalPrice', 'user', 'couponPerItem', 'couponPerPurchase', 'totalCouponsEarned'));
    }

    // History page
    public function history()
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $historyItem = History::where('user_id', $user_id)->with('product')->get();

        return view('products.history', compact('historyItem', 'user'));
    }

    public function addHistory(Request $request)
    {
        $user_id = auth()->id();

        // Get cart items
        $cartItems = Carts::where('user_id', $user_id)->get();

        foreach($cartItems as $item) {
            History::create([
                'user_id' => $user_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity
            ]);
        }

        // Clear cart
        Carts::where('user_id', $user_id)->delete();

        return redirect()->route('history')->with('success', 'Order placed successfully!');
    }

    // Generate coupon per item
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

    // Generate Total Coupons Per Purchase
    private function generateTotalCoupons($totalPrice)
    {
        // Calculate total coupons based on total purchase (every 100.000 gets 1 coupon)
        $totalCouponsEarned = floor($totalPrice / 100000);

        return $totalCouponsEarned;
    }

    // Function to get total items in cart
    private function getTotalItems()
    {
        $user_id = auth()->id();
        $totalItems = Carts::where('user_id', $user_id)->sum('quantity');
        return $totalItems;
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

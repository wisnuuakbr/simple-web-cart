@extends('layouts.master')

@section('content')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container" style="justify-content: center">
        <h5>Shopping Cart</h5>
    </div>
</nav>
<div class="container mt-4">
    <div class="row justify-content-center">
        @if($cartItems->count() > 0)
        <div class="card bg-white pt-2 mb-2">
            <div class="card-body">
                <div class="row px-4">
                    <div class="col-md-4">
                        <h6 class="text-right"><strong>Product</strong></h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-center"><strong>Price</strong></h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-center"><strong>Quantity</strong></h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-center"><strong>Total Price</strong></h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-center"><strong>Action</strong></h6>
                    </div>
                </div>
            </div>
        </div>
        @foreach($cartItems as $item)
        <div class="card bg-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6 pt-2">
                                <img src="{{ $item->product->image }}" class="img-fluid" style="width: 150px" alt="Product Image">
                            </div>
                            <div class="col-md-6 pt-4">
                                <h4 class="card-title">{{ $item->product->name }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 pt-5">
                        <p class="text-center"><strong>Rp {{ number_format($item->product->price, 0, ',', '.') }}</p></strong>
                    </div>
                    <div class="col-md-2 pt-5">
                        <p class="text-center"><strong>{{ $item->quantity }}</p></strong>
                    </div>
                    <div class="col-md-2 pt-5">
                        <p class="text-center"><strong>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p></strong>
                    </div>
                    <div class="col-md-2 pt-5 text-center">
                        <form action="{{ route('deletecart') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $item->product_id }}">
                            <button type="submit" class="btn btn-outline-danger btn-sm float-right"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Show coupons earned -->
        <div class="card bg-white mb-4">
            <div class="card-body">
                <div class="col-md-12">
                    @if(isset($couponEarned[$item->product_id]) && $couponEarned[$item->product_id] > 0)
                        <i class="fad fa-ticket fa-lg" style="--fa-primary-opacity: 1; --fa-secondary-color: #0659ea; --fa-secondary-opacity: 0.2;"></i> You've earned {{ $couponEarned[$item->product_id] }} coupon for this product!</strong>
                    @else
                        <i class="fad fa-ticket fa-lg" style="--fa-primary-opacity: 1; --fa-secondary-color: #0659ea; --fa-secondary-opacity: 0.2;"></i> No coupons earned for this product!
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        <div class="card bg-white mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 pt-3">
                        <h5>Total ({{ $totalItems }}) Product :</h5>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-8 pt-3">
                                <h5><strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></h5>
                            </div>
                            <div class="col-4 pt-1">
                                <a href="{{ url('checkout') }}" class="btn btn-warning text-white">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row text-center m-lg-5">
            <i class="fad fa-shopping-cart fa-3x"></i>
            <p class="text-muted"><strong>Your cart is Empty</strong></p>
            <div class="btn-shop">
                <a href="{{ url('product') }}" class="btn btn-warning text-white">Shop Now!</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if($cartItems->count() > 0)
        <div class="card bg-white mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h5 class="text-right"><strong>Product</strong></h5>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center"><strong>Price</strong></h5>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center"><strong>Quantity</strong></h5>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-center"><strong>Total Price</strong></h5>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center"><strong>Action</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        @foreach($cartItems as $item)
        <div class="card bg-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ $item->product->image }}" class="img-fluid" alt="Product Image">
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title">{{ $item->product->name }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <p class="text-center"><strong>Rp {{ number_format($item->product->price, 0, ',', '.') }}</p></strong>
                    </div>
                    <div class="col-md-2">
                        <p class="text-center"><strong>{{ $item->quantity }}</p></strong>
                    </div>
                    <div class="col-md-3">
                        <p class="text-center"><strong>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p></strong>
                    </div>
                    <div class="col-md-2 text-center">
                        <form action="{{ route('deletecart') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $item->product_id }}">
                            <button type="submit" class="btn btn-outline-danger btn-sm float-right">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="card bg-white mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5><strong>Total ({{ $totalItems }}) Product</strong></h5>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-8">
                                <h5><strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></h5>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-warning">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card bg-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5 class="text-center"><strong>No products available in your cart.</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

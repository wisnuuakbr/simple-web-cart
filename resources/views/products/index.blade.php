@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach($products as $product)
            <div class="col-md-3 col-6 mb-4">
                <div class="card">
                    <img src="{{ $product->image }}" class="card-img-top"/>
                    <div class="card-body">
                        <h4 class="card-title">{{ $product->name }}</h4>
                        <p>{{ $product->author }}</p>
                        <p class="card-text"><strong>Price: </strong> Rp.{{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="btn-holder"><a href="{{ route('addcart', $product->id) }}" class="btn btn-outline-danger">{{ $product->id }} Add to cart</a> </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

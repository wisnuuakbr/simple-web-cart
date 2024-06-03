@extends('layouts.master')
@section('content')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container" style="justify-content: center">
        <h5>History</h5>
    </div>
</nav>
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        @if($historyItem->count() > 0)
            @foreach($historyItem as $item)
            <div class="card bg-white mb-4">
                <div class="card-body">
                    <div class="row pt-2 px-2 mb-2">
                        <div class="col-md-6">
                            <h6>Product Ordered</h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <h6>Order has been arrived and accepted by: <strong>{{ $user->name }}</strong></h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ $item->product->image }}" class="img-fluid" style="width: 150px;" alt="Product Image">
                                </div>
                                <div class="col-md-4 pt-5">
                                    <h4 class="card-title">{{ $item->product->name }}</h4>
                                    <p class="quantity">x {{ $item->quantity }}</p>
                                </div>
                                <div class="col-md-2 pt-5">
                                    @if ($item->status === 'open')
                                        <span class="badge text-bg-primary">{{ $item->status }}</span>
                                    @else
                                        <span class="alert alert-warning">{{ $item->status }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 pt-5 d-flex justify-content-end">
                                    <p class="text-center">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row pt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <h5>Order Total ({{ $item->quantity }} Item) : Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ url('product') }}" class="btn btn-outline-warning">Buy Again</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="row text-center m-lg-5">
            <i class="fad fa-empty-set fa-3x"></i>
            <p class="text-muted"><strong>No history available</strong></p>
        </div>
        @endif
    </div>
</div>
@endsection

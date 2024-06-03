@extends('layouts.master')
@section('content')
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container" style="justify-content: center">
        <h5>Checkout</h5>
    </div>
</nav>
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="card bg-white pt-2 mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-muted"><i class="fas fa-map-marker-alt"></i> Delivery Address</h5>
                        <span>
                            <p><strong>{{ $user->name }}</strong></p>
                        </span>
                    </div>
                    <div class="col-md-6 pt-3 px-4">
                        <h6>Jl. Palagan Tentara Pelajar No.27, Jongkang, Sariharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-white">
            <div class="card-body">
                <div class="row pt-2 px-2">
                    <div class="col-md-4">
                        <h6 class="text-right">Product Ordered</h6>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-center">Price</h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-center">Amount</h6>
                    </div>
                    <div class="col-md-3">
                        <h6 class="text-center">Item Sub Total</h6>
                    </div>
                </div>
                <hr>
                @foreach($cartItems as $item)
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6 pt-4">
                                <img src="{{ $item->product->image }}" class="img-fluid" alt="Product Image">
                            </div>
                            <div class="col-md-6 pt-5">
                                <h4 class="card-title">{{ $item->product->name }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pt-5">
                        <p class="text-center"><strong>Rp {{ number_format($item->product->price, 0, ',', '.') }}</p></strong>
                        <h6 class="text-center"><i class="fad fa-ticket" style="--fa-primary-opacity: 1; --fa-secondary-color: #0659ea; --fa-secondary-opacity: 0.2;"></i> x {{ $couponPerItem[$item->product_id] }}</h6>
                    </div>
                    <div class="col-md-2 pt-5">
                        <p class="text-center"><strong>{{ $item->quantity }}</p></strong>
                    </div>
                    <div class="col-md-3 pt-5">
                        <p class="text-center"><strong>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p></strong>
                    </div>
                </div>
                @endforeach
                <hr>
                <div class="row pt-3">
                    <div class="col-md-10">
                        <h5>Order Total ({{ $totalItems }} Item) : </h5>
                    </div>
                    <div class="col-md-2">
                        <h5><strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></h5>
                        <h6><i class="fad fa-ticket" style="--fa-primary-opacity: 1; --fa-secondary-color: #0659ea; --fa-secondary-opacity: 0.2;"></i> x {{ $couponPerPurchase }}</h6>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 pt-2">
                        <i class="fad fa-ticket fa-lg" style="--fa-primary-opacity: 1; --fa-secondary-color: #0659ea; --fa-secondary-opacity: 0.2;"></i> You've earned {{ $totalCouponsEarned }} coupons total</strong>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <form action="{{ route('addhistory') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-warning text-white">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // History Process
    document.querySelectorAll('.plcae-order').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            let productId = this.getAttribute('data-id');
            let url = "{{ route('addhistory', ':id') }}".replace(':id', productId);

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = "{{ route('history') }}";
                } else {
                    throw new Error('Failed to add product!');
                }
            });
        });
    });
    </script>
@endsection

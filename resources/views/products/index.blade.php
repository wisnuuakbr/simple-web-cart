@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($products->isEmpty())
            <div class="card bg-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h5 class="text-center"><strong>No products available.</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        @else
        @foreach($products as $product)
            <div class="col-md-3 col-6 mb-4">
                <div class="card">
                    <img src="{{ $product->image }}" class="card-img-top"/>
                    <div class="card-body">
                        <h4 class="card-title">{{ $product->name }}</h4>
                        <p class="card-text"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</p></strong>
                        <p class="btn-holder">
                            <a href="{{ route('addcart', $product->id) }}" class="btn btn-outline-danger add-to-cart" data-id="{{ $product->id }}"> Add to cart</a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</div>
<script type="text/javascript">
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        let productId = this.getAttribute('data-id');
        let url = "{{ url('product') }}/" + productId;

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.success,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Update total items count
                let totalItemsElement = document.querySelector('.badge.bg-danger');
                if (totalItemsElement) {
                    totalItemsElement.textContent = data.totalItems;
                }
            }
        });
    });
});
</script>
@endsection

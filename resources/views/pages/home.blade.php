@extends('layouts.master')

@section('content')
    <x-banner />

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                @foreach ($products as $product)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            @if ($product->img_thumbnail)
                                <img class="card-img-top"
                                    src="{{ strpos($product->img_thumbnail, 'https') !== false ? $product->img_thumbnail : asset('storage/' . $product->img_thumbnail) }}"
                                    alt="..." />
                            @else
                                <img class="card-img-top" src="https://via.placeholder.com/450/300" />
                            @endif
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    <!-- Product price-->
                                    {{ $product->formatted_price }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer py-4 px-2 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <div class="row g-0">
                                        <div class="col-7">
                                            <form action="{{ route('cart.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button class="btn btn-outline-dark mt-auto" type="submit">
                                                    <i class="bi bi-cart-plus"></i>
                                                    Add to cart
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-5">
                                            <a class="btn btn-outline-dark mt-auto"
                                                href="{{ route('product.show', $product->id) }}">
                                                <i class="bi bi-eye"></i>
                                                Preview
                                            </a>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {!! $products->links() !!}
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {

                var id = $(this).data('id');

                $.ajax({
                    url: `/cart`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id: id,
                    },
                    success: (data) => {
                        console.log(data);
                    },
                    complete: (res) => {
                        console.log(res);
                    }
                })
            });
        });
    </script>
@endsection

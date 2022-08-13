@extends('layouts.master')

@section('content')
    <section class="h-100">
        <div class="container py-5">
            <h1>Shopping Cart</h1>

            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0" id="item-count">Cart - <span>{{ count($cart) }}</span> items</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($cart as $item)
                                <!-- Single item -->
                                <div class="row item">
                                    <div class="col-lg-1 col-md-1 mb-4 mb-lg-0 d-flex">
                                        <input class="form-check" type="checkbox" name="item[]"
                                            value="{{ $item->cart->id }}">
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <!-- Image -->
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded"
                                            data-mdb-ripple-color="light">
                                            <img src="{{ $item->img_thumbnail }}" class="w-100" alt="product image" />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)">
                                                </div>
                                            </a>
                                        </div>
                                        <!-- Image -->
                                    </div>

                                    <div class="col-lg-4 col-md-5 mb-4 mb-lg-0">
                                        <!-- Data -->
                                        <p><strong>{{ $item->name }}</strong></p>
                                        <button type="button" class="btn btn-primary btn-sm me-1 mb-2 item-delete"
                                            data-id="{{ $item->cart->id }}" data-mdb-toggle="tooltip" title="Remove item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <!-- Data -->
                                    </div>

                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <!-- Quantity -->

                                        <div class="d-flex mb-4" style="max-width: 300px">
                                            <button class="btn btn-primary px-3 me-2 item-quantity-minus">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <div class="form-outline">
                                                <input id="form1" min="1" name="quantity"
                                                    value="{{ $item->cart->quantity }}" type="number"
                                                    class="form-control item-quantity" data-id="{{ $item->cart->id }}"
                                                    data-price="{{ $item->price }}" />
                                                <label class="form-label" for="form1">Quantity</label>
                                            </div>

                                            <button class="btn btn-primary px-3 ms-2 item-quantity-add">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <!-- Quantity -->

                                        <!-- Price -->
                                        <p class="text-start text-md-center fw-bolder item-total-price">
                                            {{ 'Php ' . number_format($item->cart->quantity * $item->price, 2) }}
                                        </p>
                                        <!-- Price -->
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-4" />
                                @endif
                                <!-- Single item -->
                            @endforeach

                            <div id="empty-cart-div" class="text-center">
                                <h3>Cart is empty</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Summary</h5>
                        </div>
                        <div class="card-body">

                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total amount</strong>
                                    </div>
                                    <span class="fw-bolder" id="total_amount">Php 0.00</span>
                                </li>
                            </ul>

                            <form action="{{ route('checkout') }}" method="post" id="checkout-form">
                                @csrf

                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-checkout"
                                    @if (count($cart) == 0) {{ 'disabled' }} @endif>
                                    Go to checkout
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            calculateTotalAmount();
            checkIfCartIsEmpty();
            checkIfHasSelectItems();

            $('input[name="item\[\]"]').click(function() {
                calculateTotalAmount();
                checkIfHasSelectItems();
            });

            $('.item-delete').click(function() {
                var id = $(this).data('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/cart/' + id,
                    type: 'POST',
                    data: {
                        _token: token,
                        _method: 'DELETE',
                    },
                    success: (data) => {
                        removeItem(this);
                    },
                    complete: (res) => {}
                })
            });

            $(document).on('click', '.item-quantity-minus, .item-quantity-add', function() {
                var input = $(this).parent().find('.item-quantity');

                if ($(this).hasClass('item-quantity-add')) {
                    input[0].stepUp();
                } else {
                    input[0].stepDown();
                }
                input.trigger('change');

            });

            $(document).on('change', '.item-quantity', function() {
                var id = $(this).data('id');
                var price = $(this).data('price');
                var val = $(this).val();
                var total_amount = $(this).parent().parent().parent().find('.item-total-price');

                $.ajax({
                    url: `/cart/${id}`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PATCH',
                        quantity: val,
                    },
                    beforeSend: () => {
                        $(this).prop('disabled', true);
                        $(this).parent().parent().find('button').prop('disabled', true);
                    },
                    success: (data) => {
                        if (val == '') {
                            $(this).val(1);
                            $(total_amount).text('Php ' + numeral(price).format('0,0.00'));
                            return;
                        }

                        var amount = price * val;
                        $(total_amount).text('Php ' + numeral(amount).format('0,0.00'));

                        calculateTotalAmount();
                    },
                    complete: (res) => {
                        $(this).prop('disabled', false);
                        $(this).parent().parent().find('button').prop('disabled', false);
                    }
                });
            });

            $('#checkout-form').submit(function(e) {
                let cart_ids = [];
                $('input[name="item\[\]"]:checked').each(function(i, el) {
                    cart_ids.push($(el).val());
                });

                $(this).append($('<input type="hidden">').attr('name', 'cart').attr('value', cart_ids));
            });

            function updateCartCount() {
                var count = $('.item').length;

                $('#item-count span:first').text(count);

                $('#span-cart-count').text(count)
            }

            function checkIfCartIsEmpty() {
                if ($('.item').length == 0) {
                    $('#empty-cart-div').show();
                } else {
                    $('#empty-cart-div').hide();
                }
            }

            function checkIfHasSelectItems() {
                if ($('input[name="item\[\]"]:checked').length == 0) {
                    $('#btn-checkout').prop('disabled', true);
                } else {
                    $('#btn-checkout').prop('disabled', false);
                }
            }

            function calculateTotalAmount() {
                var total_amount = 0;
                $('input[name="item\[\]"]:checked').each(function(index, el) {
                    var amount = $(el).parent().parent().find('.item-total-price').first().text().trim()
                        .split(" ")[1];
                    // var amount = $(el).text().trim().split(" ")[1];

                    total_amount += Number(amount);
                });

                $('#total_amount').text('Php ' + numeral(total_amount).format('0,0.00'));
            }

            function removeItem(el) {
                var parent = $(el).parent().parent();

                if (parent.siblings('hr').length > 0) {
                    parent.siblings('hr').first().remove();
                }

                parent.remove();

                updateCartCount();
                calculateTotalAmount();
                checkIfCartIsEmpty();
                checkIfHasSelectItems();
            }
        });
    </script>
@endsection

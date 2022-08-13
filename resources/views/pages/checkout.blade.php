@extends('layouts.master')

@section('content')
    <section>
        <div class="container">
            <div class="card">
                <div class="card-body">

                    <div class="row g-5">
                        <div class="col-md-5 col-lg-4 order-md-last">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-primary">Your cart</span>
                                <span class="badge bg-primary rounded-pill">3</span>
                            </h4>
                            <ul class="list-group mb-3">
                                @foreach ($cart as $item)
                                    <li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div class="">
                                            <h6 class="my-0">{{ $item->product->name }}</h6>
                                            <small class="text-muted d-inline-block text-truncate"
                                                style="max-width: 15em!important;">{{ $item->product->description }}</small>
                                        </div>
                                        <span
                                            class="text-muted">{{ 'Php ' . number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <h4 class="mb-3">Billing address</h4>
                            <form action="{{ route('checkout.process') }}" method="POST" class="needs-validation"
                                novalidate="">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="address" class="form-label">Address*</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St"
                                            required="">
                                        <div class="invalid-feedback">
                                            Please enter your shipping address.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="address2" class="form-label">Address 2 <span
                                                class="text-muted">(Optional)</span></label>
                                        <input type="text" class="form-control" id="address2"
                                            placeholder="Apartment or suite">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="state" class="form-label">State*</label>
                                        <select class="form-select" id="country" name="country" required="">
                                            <option selected disabled hidden>Choose...</option>
                                            <option>Philippines</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="zip" class="form-label">Zip*</label>
                                        <input type="text" class="form-control" name="zip" id="zip"
                                            placeholder="" required="">
                                        <div class="invalid-feedback">
                                            Zip code required.
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h4 class="mb-3">Payment*</h4>

                                <div class="my-3">
                                    <div class="form-check">
                                        <input id="credit" name="payment_method" value="credit_card" type="radio"
                                            class="form-check-input" checked="" required="">
                                        <label class="form-check-label" for="credit">Credit card</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="debit" name="payment_method" value="debit_card" type="radio"
                                            class="form-check-input" required="">
                                        <label class="form-check-label" for="debit">Debit card</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="paypal" name="payment_method" value="Paypal" type="radio"
                                            class="form-check-input" required="">
                                        <label class="form-check-label" for="paypal">PayPal</label>
                                    </div>
                                </div>

                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <label for="cc-name" class="form-label">Name on card</label>
                                        <input type="text" class="form-control" id="cc-name" placeholder=""
                                            required="">
                                        <small class="text-muted">Full name as displayed on card</small>
                                        <div class="invalid-feedback">
                                            Name on card is required
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cc-number" class="form-label">Credit card number</label>
                                        <input type="text" class="form-control" id="cc-number" placeholder=""
                                            required="">
                                        <div class="invalid-feedback">
                                            Credit card number is required
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cc-expiration" class="form-label">Expiration</label>
                                        <input type="text" class="form-control" id="cc-expiration" placeholder=""
                                            required="">
                                        <div class="invalid-feedback">
                                            Expiration date required
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cc-cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" placeholder=""
                                            required="">
                                        <div class="invalid-feedback">
                                            Security code required
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                @foreach ($cart as $item)
                                    <input type="hidden" name="item[]" value="{{ $item->id }}">
                                @endforeach

                                <button class="w-100 btn btn-primary btn-lg" type="submit">Complete Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

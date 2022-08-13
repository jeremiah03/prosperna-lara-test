@extends('layouts.master')

@section('content')
    <section>
        <div class="container">
            <div class="card">
                <div class="card-body text-center">
                    <h3>
                        Order Completed.
                    </h3>
                    <p>
                        Order was successfully made.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">Shop Again</a>
                </div>
            </div>
        </div>
    </section>
@endsection

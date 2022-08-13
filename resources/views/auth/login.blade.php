@extends('layouts.master')

@section('content')
    <section class="gradient-custom">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif
                                <div class="mb-md-5 mt-md-4 pb-5">

                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" id="email"
                                            class="form-control form-control-lg" />
                                        <label class="form-label" for="email">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-lg" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    <p class="small mb-5 pb-lg-2">
                                        <a class="text-white-50" href="#!">Forgot password?</a>
                                    </p>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                                </div>

                                <div>
                                    <p class="mb-0">Don't have an account? <a href="#!"
                                            class="text-white-50 fw-bold">Sign Up</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

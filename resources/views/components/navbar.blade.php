<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light position-fixed w-100 shadow" style="z-index: 999">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('home') }}">Prosperna Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                @auth
                    @if (auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('product.index') }}">
                                Manage Products
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
            <a class="btn btn-outline-dark" href="{{ route('cart.index') }}">
                <i class="bi-cart-fill me-1"></i>
                Cart
                <span class="badge bg-dark text-white ms-1 rounded-pill" id="span-cart-count">{{ $item_count }}</span>
            </a>

            @auth
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary mx-5">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
<!-- End Navigation -->

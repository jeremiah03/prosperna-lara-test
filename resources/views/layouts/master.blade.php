<!DOCTYPE html>
<html lang="en">

<x-header />

<body style="min-height: 100vh;">
    <x-navbar />

    <div style="padding-top:6rem!important;min-height:90vh;">
        <!-- Section-->
        @yield('content')
        <!-- End Sector -->
    </div>

    <x-footer />


    @if (!request()->is('login') && !request()->is('register'))
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
    @endif

    @yield('link-script')
    @yield('script')
</body>

</html>

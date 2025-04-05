@include('shop.components.head')

@if(request()->routeIs('shop.signup') || request()->routeIs('shop.login'))

    @yield('content')

@else

    @include('shop.components.header')

    @yield('content')

    @include('shop.components.footer')

@endif

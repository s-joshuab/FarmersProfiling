@include('layouts.header')
@include('layouts.navbar')
@include('layouts.secretary.secretarysidebar')
<main id="main" class="main">
    @yield('content')
</main>
@include('layouts.footer')

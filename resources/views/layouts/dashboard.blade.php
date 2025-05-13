@include('layouts.header')
@include('layouts.navbar')
@include('layouts.admin.adminsidebar')
<main id="main" class="main">
    @yield('content')
</main>
@include('layouts.footer')

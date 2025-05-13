<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="../../assets/img/balaoan-5.webp" rel="icon">
    <link href="../../assets/img/balaoan-5.webp" rel="apple-touch-icon">
    {{-- title --}}
    <title>Balaoan Farmer's Profile</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <link href="../../assets/css/bootstrap1.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
{{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> --}}

<!-- Vendor CSS Files -->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+zJ3eY6eo8o2+a/aB/3ivV4x4IHgIEasyA+8F+3" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
<link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
<link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}

<!-- Alphine -->
<script defer src="{{ asset('assets/js/defersrc.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/boostrap@5.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
{{-- <script src="{{ asset('assets/js/shield.js') }}"></script> --}}
<script src="{{ asset('assets/js/jszip.js') }}"></script>
<!-- Template Main CSS File -->
<link href="../../assets/css/style.css" rel="stylesheet">
<link href="../../assets/css/id.css" rel="stylesheet">
<link href="../../assets/css/awesome.css" rel="stylesheet">
<link href="../../assets/css/awesomee.css" rel="stylesheet">
<link href="../../assets/css/fonts.css" rel="stylesheet">
<link href="../../assets/css/all.min.css" rel="stylesheet">
@livewireStyles
  </head>


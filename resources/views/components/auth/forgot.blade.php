@include('layouts.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body
    style="background-image: url('{{ asset('assets/img/bg.png') }}'); background-size: cover;
background-position: center;
background-repeat: no-repeat;
">
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center py-4">
                                        <a href="#" class="balaoann-logo">
                                            <img src="assets/img/balaoann.png" alt="" class="logo-image"
                                                style="height: 80px; width: 80px;">
                                        </a>
                                        <span class="balaoann-text">Municipal Agriculturist Office</span>
                                    </div>
                                    <form class="row g-3" action="{{ route('password.email') }}" method="post">
                                        @csrf
                                        <!-- CSRF token -->
                                        <!-- Display success or error messages -->
                                        {{-- @if (session()->has('status'))
                                    <div class="col-12">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <!-- Edit the success message here -->
                                            {{ session('status') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                    @endif --}}

                                        {{-- @if ($errors->has('email'))
<div class="col-12">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <!-- Custom message for email not found -->
        Email Not Found in the System

    </div>
</div>
@endif --}}



                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend">
                                                    <i class="bi bi-person-fill"></i> <!-- User Icon -->
                                                </span>
                                                <input type="email" name="email" class="form-control" id="yourEmail"
                                                    required>
                                                <div class="invalid-feedback">Please enter your Email.</div>
                                            </div>
                                            <span class="text-success text-xs" style="font-weight:bolder;">
                                                @if (session()->has('status'))
                                                    Password reset instructions sent to your email.
                                                @endif
                                            </span>
                                            <span class="text-danger text-xs" style="font-weight:bolder;">
                                                @if ($errors->has('email'))
                                                    Email Not Found in the System
                                                @endif
                                            </span>

                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button class="btn btn-primary" type="submit">Forgot Password</button>
                                            </div>
                                        </div>
                                    </form>




                                    <script>
                                        // JavaScript to add the 'was-validated' class to the form after submission
                                        const form = document.querySelector('.needs-validation');
                                        form.addEventListener('submit', function(event) {
                                            if (!form.checkValidity()) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                            }
                                            form.classList.add('was-validated');
                                        });
                                    </script>


                                </div>
                            </div>


                            <div class="copyright">
                                &copy; Copyright <strong><span>Balaoan, La Union</span></strong>. All Rights Reserved
                            </div>
                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-xY9lAwqgA7Gu9DKAJo2+/7t4x6gAoMfM0ZK/p01vpLYyTdxNI0QHy3h3eVpWMftM" crossorigin="anonymous">
    </script>

    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>


</html>

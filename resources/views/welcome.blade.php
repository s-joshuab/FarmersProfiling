@include('layouts.header')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body style="background-image: url('{{ asset('assets/img/bg.png') }}'); background-size: cover;
background-position: center;
background-repeat: no-repeat;
">
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center py-4">
                                    <a href="#" class="balaoann-logo">
                                        <img src="{{ asset('assets/img/balaoan-5.webp') }}" alt="Balaoan Image"
                                            class="logo-image" style="height: 80px; width: 80px;">
                                    </a>
                                    <span class="balaoann-text">Municipal Agriculturist Office</span>
                                </div>

                                {{-- @if (session()->has('message'))
                                    <div class="alert alert-success text-center">
                                        {{ session('message') }}
                                    </div>
                                @endif --}}

                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                @if (session('reset_success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: '{{ session('reset_success') }}',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                                @endif


                                <form class="row g-3 needs-validation" action="{{ route('login') }}" method="post"
                                    novalidate>
                                    @csrf
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
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <div class="input-group password-input-group">
                                            <span class="input-group-text" id="inputGroupPrepend2">
                                                <i class="bi bi-key-fill"></i> <!-- Key Icon -->
                                            </span>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            <button class="password-toggle" type="button" id="showPasswordButton">
                                                <i class="bi bi-eye"></i> <!-- Eye Icon -->
                                            </button>
                                            <div class="invalid-feedback">Please enter a password!</div>
                                        </div>
                                    </div>

                                  <div class="col-12">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="acceptTerms" name="acceptTerms" required>
        <label class="form-check-label" for="acceptTerms">
            I accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
        </label>
        <div class="invalid-feedback">You must accept the Terms and Conditions.</div>
    </div>
</div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ url('forgot-password') }}">Forgot Password?</a>
                                            <button class="btn btn-primary" type="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
             <style>
                    .copyright a {
                        color: #004289; /* Example color, change to your preferred color */
                    }
                </style>
                <div class="col-md-12 text-center">
                    <div class="copyright">
                        &copy; Copyright <strong>
                            <a href="https://www.facebook.com/joshua.sacquiaten.2" target="_blank">Joshua B. Sacquiaten</a>
                            <span> and </span>
                            <a href="https://www.facebook.com/andrei.eleazar.1" target="_blank">Andrei Eleazar B. Ballesteros</a>
                        </strong> <br>All Rights Reserved
                    </div>
                </div>
        </section>
    </div>
</main>
</body>
<!-- Modal for Terms and Conditions -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <p><strong>• Acceptance of Terms</strong></p>
                        <p>
                            By accessing or using our profiling system, you agree to comply with and be bound by the
                            following terms and conditions. If you do not agree to these terms, please do not use the
                            profiling system.
                        </p>

                        <p><strong>• Description of the Profiling System</strong></p>
                        <p>
                            Our profiling system is designed and develop a system to store large data of farmers allowing them have an organized, summarized, and secured records of farmers.
                        </p>

                        <p><strong>• User Consent</strong></p>
                        <p>
                            By using the profiling system, you consent to the collection, use, and disclosure of your
                            information as outlined in these terms and our privacy policy.
                        </p>

                        <p><strong>• Data Collection and Usage</strong></p>
                        <p>
                            We may collect and process various types of information, including but not limited to
                            all data of the farmers. This information is used for farmers profiling system in Balaoan, La Union
                        </p>

                        <p><strong>• Data Security</strong></p>
                        <p>
                            We take reasonable measures to secure your data; however, we cannot guarantee the absolute
                            security of your information. By using the profiling system, you acknowledge and accept this
                            risk.
                        </p>

                        <p><strong>• User Responsibilities</strong></p>
                        <p>
                            You are responsible for maintaining the confidentiality of your account information and for
                            all activities that occur under your account.
                        </p>

                        <p><strong>• Cookies and Tracking</strong></p>
                        <p>
                            Our profiling system may use cookies or similar technologies to enhance user experience.
                            You can manage cookie preferences through your browser settings.
                        </p>

                        <p><strong>• Termination</strong></p>
                        <p>
                            We reserve the right to terminate or suspend your account for any reason without prior
                            notice.
                        </p>

                        <p><strong>• Changes to Terms</strong></p>
                        <p>
                            We may update these terms from time to time. You will be notified of any changes, and
                            continued use of the profiling system after such modifications constitutes your acceptance
                            of the new terms.
                        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>



<style>
    .password-input-group {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        background: none;
        border: none;
    }
</style>
<script>
    const passwordInput = document.getElementById("yourPassword");
    const showPasswordButton = document.getElementById("showPasswordButton");

    showPasswordButton.addEventListener("click", () => {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = '<i class="bi bi-eye-slash"></i>'; // Change button icon
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = '<i class="bi bi-eye"></i>'; // Change button icon
        }
    });
</script>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
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

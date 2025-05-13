@extends('layouts.index')
@section('content')
<title>Profile</title>

<div class="pagetitle">
    <h1>Profile</h1>
  </div><!-- End Page Title -->


@if (session()->has('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">




    @foreach ($someData as $data)
    <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="data:image/jpeg;base64,{{ $data->image }}" alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px;">
            <h2>{{ $data->name }}</h2>
            <h3><span>Brgy. </span>{{ $data->user_type }}</h3>
        </div>
    </div>
    @endforeach


      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>


              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8">{{ $user->barangay->barangays }} , {{ $user->municipalities_id }} , {{ $user->provinces_id }} </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Contact Number</div>
                  <div class="col-lg-9 col-md-8">{{ $user->phone_number }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                            <img src="data:image/jpeg;base64,{{ $data->image }}" alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px;">
                            <div class="pt-2">
                                <input type="file" name="image" id="image" accept="image/*">

                            </div>
                        </div>
                    </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="validationTooltip01" name="name" required
                                autofocus="autofocus" value="{{ $user->name }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 position-relative mt-0 mb-2">
                        <label for="province">Province:</label>
                        <div class="form-control-custom">
                            <input type="text" id="provinces_id" name="provinces_id" class="form-control" value="La Union" readonly>
                          </div>
                    </div>

                    <div class="col-md-4 position-relative mt-0 mb-2">
                        <label for="municipality">Municipality:</label>
                        <div class="form-control-custom">
                            <input type="text" id="provinces_id" name="municipalities_id" class="form-control" value="Balaoan" readonly>
                          </div>
                    </div>

                    <div class="col-md-4 position-relative mt-0 mb-2">
                        <label for="barangay">Barangay:</label>
                        <select id="barangay" name="barangays_id" disabled class="form-control" required>
                            <option value="">Select Barangay</option>
                            @foreach ($barangays as $barangay)
                                <option value="{{ $barangay->id }}"
                                    {{ $user->barangays_id == $barangay->id ? 'selected' : '' }}>
                                    {{ $barangay->barangays }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- <!-- Barangay Dropdown -->
                    <div class="col-md-4 position-relative mt-0">
                        <label for="municipality">Municipality:</label>
                        <select id="municipality" name="barangays_id" class="form-control">
                            <option value="">Select Municipality</option>
                            @foreach ($barangays as $barangay)
                                <option value="{{ $barangay->id }}"
                                    {{ $user->barangays_id == $barangay->id ? 'selected' : '' }}>
                                    {{ $barangay->barangays }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    // Function to fetch province and municipality based on the selected barangay
                    function getProvinceAndMunicipality(barangay_id) {
                        // Placeholder for fetching data based on barangay (replace with actual logic)
                        var province_id = 1; // La Union
                        var municipality_id = 1; // Balaoan

                        // Set the selected province and municipality
                        $('#province').val(province_id);
                        $('#municipality').val(municipality_id);

                        // Show the hidden dropdowns
                        $('#province, #municipality').show();
                    }

                    // Add event listener for the barangay select dropdown
                    $('#barangay').change(function() {
                        var barangay_id = $(this).val();
                        if (barangay_id !== '') {
                            getProvinceAndMunicipality(barangay_id);
                        }
                    });

                    // Add event listener for the form submission
                    $('#dataForm').submit(function(event) {
                        event.preventDefault(); // Prevent the default form submission

                        var formData = $(this).serialize(); // Serialize the form data

                        $.ajax({
                            url: '/save-data',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                // Handle the success response, e.g., show a success message
                                alert(response.message);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                // Handle the error response if needed
                            }
                        });

                        // If you still want to submit the form after the Ajax call, you can do it here
                        // Uncomment the next line if you want to submit the form after the Ajax call
                        // this.submit();
                    });
                </script>
                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="validationTooltip01" name="phone_number"
                        maxlength="11" required autofocus="autofocus" value="{{ $user->phone_number }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="email" class="form-control" id="validationTooltip01" name="email" required
                        autofocus="autofocus" value="{{ $user->email }}">
                    </div>
                  </div>

                  <div class="col-12 mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="margin-right: 5px;"
                        name="submit">Save User</button>
                </div>
                </form><!-- End Profile Edit Form -->
              </div>






              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form action="{{ route('password.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9 input-group">
                            <input name="current_password" type="password" class="form-control" id="currentPassword" value="">
                            <span class="input-group-text">
                                <i class="bi bi-eye" id="toggleCurrentPassword" onclick="togglePassword('currentPassword', 'toggleCurrentPassword')"></i>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
    <div class="col-md-8 col-lg-9 input-group">
        <input name="new_password" type="password" class="form-control" id="newPassword" oninput="validatePasswords()">
        <span class="input-group-text">
            <i class="bi bi-eye" id="toggleNewPassword" onclick="togglePassword('newPassword', 'toggleNewPassword')"></i>
        </span>
    </div>
</div>

<div class="row mb-3">
    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
    <div class="col-md-8 col-lg-9 input-group">
        <input name="new_password_confirmation" type="password" class="form-control" id="renewPassword" oninput="validatePasswords()">
        <span class="input-group-text">
            <i class="bi bi-eye" id="toggleRenewPassword" onclick="togglePassword('renewPassword', 'toggleRenewPassword')"></i>
        </span>
    </div>
    <div class="row mb-3">
        <small id="passwordMatchMessage" style="color: red; display: none;">Passwords do not match!</small>
    </div>
</div>

<div class="col-12 mt-4 d-flex justify-content-end"> <button type="submit" class="btn btn-primary" style="margin-right: 5px;" name="submit">Save User</button>
</div>
 </form>
<script>
    function togglePassword(inputId, toggleIconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(toggleIconId);
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        }
    }

    function validatePasswords() {
        const newPassword = document.getElementById("newPassword").value;
        const renewPassword = document.getElementById("renewPassword").value;
        const message = document.getElementById("passwordMatchMessage");
        
        if (renewPassword !== "" && newPassword !== renewPassword) {
            message.style.display = "block"; // Show error message
        } else {
            message.style.display = "none"; // Hide error message
        }
    }
</script>


              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
@endsection

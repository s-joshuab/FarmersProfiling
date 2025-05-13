@extends('layouts.index')
@section('content')
<title>View Users Information</title>

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

    <div class="col-12 mb-2 d-flex justify-content-end">
        <button type="reset" class="btn btn-success" id="backBtn">Back</button>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <h5 class="card-title"></h5>

                    <form action="{{ url('admin/users') }}" method="POST">
                        @csrf
                        <div class="col-md-12 position-relative">
                            <label class="form-label">Name<font color="red">*</font></label>
                            <input type="text" class="form-control" id="validationTooltip01" name="name" required
                                autofocus="autofocus" value="{{ $user->name }}" disabled>
                            <div class="invalid-tooltip">
                                The Fullname field is required.
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-4 position-relative mt-0">
                            <label for="municipality">Municipality:</label>
                            <select id="municipality" name="municipalities_id" class="form-control" disabled>
                                <option value="">Select Municipality</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $user->provinces_id == $province->id ? 'selected' : '' }}>
                                        {{ $province->provinces }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Municipality Dropdown -->
                        <div class="col-md-4 position-relative mt-0">
                            <label for="municipality">Municipality:</label>
                            <select id="municipality" name="municipalities_id" class="form-control" disabled>
                                <option value="">Select Municipality</option>
                                @foreach ($municipalities as $municipality)
                                    <option value="{{ $municipality->id }}" {{ $user->municipalities_id == $municipality->id ? 'selected' : '' }}>
                                        {{ $municipality->municipalities }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Barangay Dropdown -->
                        <div class="col-md-4 position-relative mt-0">
                            <label for="municipality">Municipality:</label>
                            <select id="municipality" name="municipalities_id" class="form-control" disabled>
                                <option value="">Select Municipality</option>
                                @foreach ($barangays as $barangay)
                                    <option value="{{ $barangay->id }}" {{ $user->barangays_id == $barangay->id ? 'selected' : '' }}>
                                        {{ $barangay->barangays }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div>

                        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            // Function to fetch municipalities based on the selected province
                            function getMunicipalities(province_id) {
                                $.ajax({
                                    url: '/get-municipalities/' + province_id,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        // Clear previous options
                                        $('#municipality').empty().append('<option value="">Select Municipality</option>');
                                        $('#barangay').empty().append('<option value="">Select Barangay</option>');

                                        // Append new options
                                        $.each(response, function(index, municipality) {
                                            $('#municipality').append('<option value="' + municipality.id + '">' + municipality.municipalities + '</option>');
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }

                            // Function to fetch barangays based on the selected municipality
                            function getBarangays(municipality_id) {
                                $.ajax({
                                    url: '/get-barangays/' + municipality_id,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        // Clear previous options
                                        $('#barangay').empty().append('<option value="">Select Barangay</option>');

                                        // Append new options
                                        $.each(response, function(index, barangay) {
                                            $('#barangay').append('<option value="' + barangay.id + '">' + barangay.barangays + '</option>');
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }

                            // Add event listener for the province select dropdown
                            $('#province').change(function() {
                                var province_id = $(this).val();
                                if (province_id !== '') {
                                    getMunicipalities(province_id);
                                }
                            });

                            // Add event listener for the municipality select dropdown
                            $('#municipality').change(function() {
                                var municipality_id = $(this).val();
                                if (municipality_id !== '') {
                                    getBarangays(municipality_id);
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
                        </script> --}}

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Username<font color="red">*</font></label>
                                <input type="text" class="form-control" id="validationTooltip01" name="username"
                                    required autofocus="autofocus" value="{{ $user->username }}" disabled>
                                <div class="invalid-tooltip">
                                    The Username field is required.
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">Password<font color="red">*</font></label>
                                <input type="password" class="form-control" id="pass" name="password" required autofocus="autofocus"  disabled>
                                <input type="checkbox" onclick="myFunction()">Show Password
                                <div class="invalid-tooltip">
                                    The Password field is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Email Address<font color="red">*</font></label>
                                <input type="email" class="form-control" id="validationTooltip01" name="email" required autofocus="autofocus" value="{{ $user->email }}" disabled>
                                <div class="invalid-tooltip">
                                    The Email Address field is required.
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">PhoneNumber (Format: 09XXXXXXXXX)<font color="red">*</font>
                                    </label>
                                <input type="text" class="form-control" id="validationTooltip01" name="phone_number"
                                    maxlength="11" required autofocus="autofocus" value="{{ $user->phone_number }}" disabled>
                                <div class="invalid-tooltip">
                                    The Contact Number field is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">User Type<font color="red">*</font></label>
                                <div class="col-sm-12">
                                    <select class="form-select" aria-label="Default select example" name="user_type" id="validationTooltip03" required autofocus="autofocus" disabled>
                                        <option value="" selected disabled>Select User Type</option>
                                        <option value="Admin" {{ $user->user_type === 'Admin' ? 'selected' : '' }}>Administrator</option>
                                        <option value="Staff" {{ $user->user_type === 'Staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="Secretary" {{ $user->user_type === 'Secretary' ? 'selected' : '' }}>
                                            @if($user->user_type === 'Secretary')
                                                Brgy. Secretary
                                            @else
                                                Secretary
                                            @endif
                                        </option>

                                    </select>
                                    <div class="invalid-tooltip">
                                        The User Type field is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">Status<font color="red">*</font></label>
                                <div class="col-sm-12">
                                    <select class="form-select" aria-label="Default select example" id="validationTooltip03" name="status" required autofocus="autofocus" disabled>
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="Active" {{ $user->status === 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $user->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        The Active field is required.
                                    </div>
                                </div>
                            </div>
                        </div>



                    </form><!-- End Custom Styled Validation with Tooltips -->

                </div>
            </div>

        </div>
    </div>
    <script>
    document.getElementById("backBtn").onclick = function() {
        // Go back to the previous page
        window.history.back();
      };
      </script>

               <script>
            function myFunction() {
  var passwordInput = document.getElementById("pass");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
  } else {
    passwordInput.type = "password";
  }
}
</script>
@endsection

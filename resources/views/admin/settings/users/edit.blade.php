@extends('layouts.index')
@section('content')
<title>Update Users</title>

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

    @can('admin-access')

    <div class="col-12 mb-3 d-flex justify-content-end">
        <button type="reset" class="btn btn-success" id="cancelBtn">Cancel</button>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <h5 class="card-title"></h5>

                    <form action="{{ url('user-update/' . $user->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="col-md-12 position-relative">
                            <label class="form-label">Name<font color="red">*</font></label>
                            <input type="text" class="form-control" id="validationTooltip01" name="name" required
                                autofocus="autofocus" value="{{ $user->name }}">
                            <div class="invalid-tooltip">
                                The Fullname field is required.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 position-relative mt-0">
                                <label for="province">Province:</label>
                                <div class="form-control-custom">
                                    <input type="text" id="provinces_id" name="provinces_id" class="form-control" value="La Union" readonly>
                                  </div>
                            </div>

                            <div class="col-md-4 position-relative mt-0">
                                <label for="municipality">Municipality:</label>
                                <div class="form-control-custom">
                                    <input type="text" id="provinces_id" name="municipalities_id" class="form-control" value="Balaoan" readonly>
                                  </div>
                            </div>

                            <div class="col-md-4 position-relative mt-0">
                                <label for="barangay">Barangay:</label>
                                <select id="barangay" name="barangays_id" class="form-control" required>
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


                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Username<font color="red">*</font></label>
                                <input type="text" class="form-control" id="validationTooltip01" name="username" required
                                    autofocus="autofocus" value="{{ $user->username }}">
                                <div class="invalid-tooltip">
                                    The Username field is required.
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">Password<font color="red">*</font></label>
                                <input type="password" class="form-control" id="pass" name="password"
                                    autofocus="autofocus">
                                <input type="checkbox" onclick="myFunction()">Show Password
                                <div class="invalid-tooltip">
                                    The Password field is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Email Address<font color="red">*</font></label>
                                <input type="email" class="form-control" id="validationTooltip01" name="email" required
                                    autofocus="autofocus" value="{{ $user->email }}">
                                <div class="invalid-tooltip">
                                    The Email Address field is required.
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">PhoneNumber (Format: 09XXXXXXXXX)<font color="red">*</font>
                                </label>
                                <input type="text" class="form-control" id="validationTooltip01" name="phone_number"
                                    maxlength="11" required autofocus="autofocus" value="{{ $user->phone_number }}">
                                <div class="invalid-tooltip">
                                    The Contact Number field is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">User Type<font color="red">*</font></label>
                                <div class="col-sm-12">
                                    <select class="form-select" aria-label="Default select example" name="user_type"
                                        id="validationTooltip03" required autofocus="autofocus">
                                        <option value="" selected disabled>Select User Type</option>
                                        <option value="Admin" {{ $user->user_type === 'Admin' ? 'selected' : '' }}>
                                            Administrator</option>
                                        <option value="Staff" {{ $user->user_type === 'Staff' ? 'selected' : '' }}>Staff
                                        </option>
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
                                    <select class="form-select" aria-label="Default select example"
                                        id="validationTooltip03" name="status" required autofocus="autofocus">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="Active" {{ $user->status === 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ $user->status === 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        The Active field is required.
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12 mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;"
                                name="submit">Save User</button>
                        </div>
                    </form><!-- End Custom Styled Validation with Tooltips -->

                </div>
            </div>

        </div>
    </div>
    @endcan

    @can('staff-access')

    <div class="col-12 mb-3 d-flex justify-content-end">
        <button type="reset" class="btn btn-success" id="cancelBtn">Cancel</button>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <h5 class="card-title"></h5>

                    <form action="{{ url('user-update/' . $user->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="col-md-12 position-relative">
                            <label class="form-label">Name<font color="red">*</font></label>
                            <input type="text" class="form-control" id="validationTooltip01" name="name" required
                                autofocus="autofocus" value="{{ $user->name }}">
                            <div class="invalid-tooltip">
                                The Fullname field is required.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 position-relative mt-0">
                                <label for="province">Province:</label>
                                <div class="form-control-custom">
                                    <input type="text" id="provinces_id" name="provinces_id" class="form-control" value="La Union" readonly>
                                  </div>
                            </div>

                            <div class="col-md-4 position-relative mt-0">
                                <label for="municipality">Municipality:</label>
                                <div class="form-control-custom">
                                    <input type="text" id="provinces_id" name="municipalities_id" class="form-control" value="Balaoan" readonly>
                                  </div>
                            </div>

                            <div class="col-md-4 position-relative mt-0">
                                <label for="barangay">Barangay:</label>
                                <select id="barangay" name="barangays_id" class="form-control" required>
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



                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Username<font color="red">*</font></label>
                                <input type="text" class="form-control" id="validationTooltip01" name="username" required
                                    autofocus="autofocus" value="{{ $user->username }}">
                                <div class="invalid-tooltip">
                                    The Username field is required.
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">Password<font color="red">*</font></label>
                                <input type="password" class="form-control" id="pass" name="password" required
                                    autofocus="autofocus">
                                <input type="checkbox" onclick="myFunction()">Show Password
                                <div class="invalid-tooltip">
                                    The Password field is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Email Address<font color="red">*</font></label>
                                <input type="email" class="form-control" id="validationTooltip01" name="email" required
                                    autofocus="autofocus" value="{{ $user->email }}">
                                <div class="invalid-tooltip">
                                    The Email Address field is required.
                                </div>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label">PhoneNumber (Format: 09XXXXXXXXX)<font color="red">*</font>
                                </label>
                                <input type="text" class="form-control" id="validationTooltip01" name="phone_number"
                                    maxlength="11" required autofocus="autofocus" value="{{ $user->phone_number }}">
                                <div class="invalid-tooltip">
                                    The Contact Number field is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">User Type<font color="red">*</font></label>
                                <div class="col-sm-12">
                                    <select class="form-select" aria-label="Default select example" name="user_type"
                                        id="validationTooltip03" required autofocus="autofocus">
                                        <option value="" selected disabled>Select User Type</option>

                                        <option value="Staff" {{ $user->user_type === 'Staff' ? 'selected' : '' }}>Staff
                                        </option>
                                        <option value="Secretary" {{ $user->user_type === 'Secretary' ? 'selected' : '' }}>
                                            Secretary</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        The User Type field is required.
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-6 position-relative">
                                <label class="form-label">Status<font color="red">*</font></label>
                                <div class="col-sm-12">
                                    <select class="form-select" aria-label="Default select example"
                                        id="validationTooltip03" name="status" required autofocus="autofocus">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="Active" {{ $user->status === 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ $user->status === 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        The Active field is required.
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12 mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;"
                                name="submit">Save User</button>
                        </div>
                    </form><!-- End Custom Styled Validation with Tooltips -->

                </div>
            </div>

        </div>
    </div>
    @endcan
    <script>
        document.getElementById("cancelBtn").onclick = function() {
            // Go back to the previous page
            window.history.back();
        };

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

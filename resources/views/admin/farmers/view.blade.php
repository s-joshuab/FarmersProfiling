@extends('layouts.index')
@section('content')
<title>View Information</title>

<div class="col-12 mb-2 d-flex justify-content-end">
    <button type="reset" class="btn btn-success" id="backBtn">Back</button>
</div>
<script>
    document.getElementById("backBtn").onclick = function() {
        // Go back to the previous page
        window.history.back();
      };
</script>
<style>
    label{
        font-weight: bold;
    }
</style>

<div class="row">
    <div class="container">
        <div class="col-lg-12">
            <form action="{{ url('admin/create') }}" method="post">
                @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center mt-3">
                            <h5
                                style="font-family:'Times New Roman', Times, serif; font-weight: bold; font-size: 30px; color: black;">
                                BALAOAN FARMERS REGISTRY</h5>
                        </div>
                        <div class="col-md-6 position-relative mt-5">
                            <div class="d-flex align-items-center">
                                <label for="referenceNo" class="mr-2" style="font-weight: bold;">Reference/Control No.: </label>
                                <div class="flex-grow-1">
                                    <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="referenceNo"
                                        name="ref_no" value="{{ $farmersprofile->ref_no }}" required disabled>
                                            </div>
                                        </div>
                                    </div>
{{--

                                    <div class="col-md-6 position-relative mt-5">
                                            <div class="form-group">
                                                <label for="cstatus">Civil Status:</label>
                                                <select class="form-control" id="cstatus" name="civil_status_id" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;"
                                                    onchange="handleCivilStatusSelect()" disabled required>
                                                    <option value="">Select Civil Status</option>
                                                    @foreach($civilStatusOptions as $status)
                                                    <option value="{{ $status->id }}" {{ $farmersprofile->civil_status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->status }}
                                                    </option>
                                                @endforeach
                                                </select>
                                                <div class="invalid-tooltip">
                                                    Please select one option for Civil Status.
                                                </div>
                                            </div>
                                        </div> --}}

                                    <div class="col-md-6 position-relative mt-5">
                                        <div class="d-flex align-items-center">
                                            <label class="form-label" style="font-weight: bold;">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none; background-color: white;" aria-label="Default select example" id="validationTooltip03" name="status" required disabled>
                                                    <option value="">Select Status</option>
                                                    <option value="Active" {{ $farmersprofile->status === 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ $farmersprofile->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <hr class="mt-2">
                                    <p class="mt-0" style="font-weight: bold; font-size: 12px;">PART I. PERSONAL INFORMATION</p>

                                    <div class="col-md-6 position-relative mt-0">
                                        <label class="form-label" style="font-weight: bold;">Surname</label>
                                        <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationTooltip01" name="sname"  value="{{ $farmersprofile->sname }}" required
                                            autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The Surname field is required.
                                        </div>
                                    </div>

                                    <div class="col-md-6 position-relative mt-0">
                                        <label class="form-label" style="font-weight: bold;">First Name</label>
                                        <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationTooltip01" name="fname" value="{{ $farmersprofile->fname }}"
                                            required autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The First Name field is required.
                                        </div>
                                    </div>

                                    <div class="col-md-5 position-relative mt-0">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationTooltip01" name="mname" value="{{ $farmersprofile->mname ?: 'N/A' }}" required autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The Middle Name field is required.
                                        </div>
                                    </div>

                                    <div class="col-md-3 position-relative mt-0">
                                        <label class="form-label">Extension Name</label>
                                        <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationTooltip01" name="ename" value="{{ $farmersprofile->ename ?: 'N/A' }}" required autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The Extension Name field is required.
                                        </div>
                                    </div>

                                    <div class="col-md-4 position-relative" style="margin-top: 35px;">
                                        <div class="form-inline">
                                            <label for="sex" class="mr-2">Sex:</label>
                                            @if($farmersprofile->sex === 'Male')
                                                <div class="form-check form-check-inline">
                                                    <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="sex" name="sex" class="form-control" value="{{ $farmersprofile->sex ?: 'N/A' }}" disabled>
                                                </div>
                                            @elseif($farmersprofile->sex === 'Female')
                                                <div class="form-check form-check-inline">
                                                    <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="sex" name="sex" class="form-control" value="{{ $farmersprofile->sex ?: 'N/A' }}" disabled>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                    <hr class="mt-2">
                                    <p class="mt-0" style="font-weight:bold; font-size: 12px;">ADDRESS</p>
                                    <div class="col-md-4 position-relative mt-0">
                                        <label for="Region">Region</label>
                                        <div class="form-control-custom">
                                          <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" id="regions" name="regions" class="form-control" value="Region I" disabled>
                                        </div>
                                      </div>



                                    <!-- Beekeeper Province Address -->
                                    <div class="col-md-4 position-relative mt-0">
                                        <label for="province">Province:</label>
                                        <div class="form-control-custom">
                                            <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" id="provinces_id" name="provinces_id" class="form-control" value="La Union" readonly>
                                          </div>
                                    </div>

                                    <div class="col-md-4 position-relative mt-0">
                                        <label for="municipality">Municipality:</label>
                                        <div class="form-control-custom">
                                            <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" id="provinces_id" name="municipalities_id" class="form-control" value="Balaoan" readonly>
                                          </div>
                                    </div>

                                    <div class="col-md-4 position-relative mt-2">
                                        <label for="barangay">Barangay:</label>
                                        <select id="barangay" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" name="barangays_id" class="form-control" required disabled>
                                            <option value="">Select Barangay</option>
                                            @foreach ($barangays as $barangay)
                                                <option value="{{ $barangay->id }}" {{ $farmersprofile->barangays_id == $barangay->id ? 'selected' : '' }}>
                                                    {{ $barangay->barangays }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Barangay Dropdown -->
                                    {{-- <div class="col-md-4 position-relative mt-0">
                                        <label for="municipality">Municipality:</label>
                                        <select id="municipality" name="municipalities_id" class="form-control" disabled>
                                            <option value="">Select Municipality</option>
                                            @foreach ($barangays as $barangay)
                                                <option value="{{ $barangay->id }}" {{ $farmersprofile->barangays_id == $barangay->id ? 'selected' : '' }}>
                                                    {{ $barangay->barangays }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}

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

                                    <div class="col-md-4 position-relative mt-0">
                                        <label class="form-label">Street/Sitio/Purok/Subdv.</label>
                                        <input type="text" class="form-control" id="validationTooltip01"
                                            name="purok" value="{{ $farmersprofile->purok}}" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" required autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The Street/Sitio/Purok/Subdv. field is required.
                                        </div>
                                    </div>

                                    <div class="col-md-4 position-relative mt-0">
                                        <label class="form-label">House/Lot/Bldg. No.</label>
                                        <input type="text" class="form-control" id="validationTooltip01" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" value="{{ $farmersprofile->house ?: 'N/A' }}" name="house" required autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The House/Lot/Bldg. No. field is required.
                                        </div>
                                    </div>

                                    <hr class="mt-2">


                                    <div class="col-md-6 position-relative mt-0">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="validationTooltip01" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" value="{{ $farmersprofile->number}}"
                                            name="number" required autofocus="autofocus" disabled>
                                        <div class="invalid-tooltip">
                                            The contactnumber field is required.
                                        </div>
                                    </div>


                                    <div class="col-md-6 position-relative mt-0">
                                        <div class="form-group">
                                            <label for="highest_formal_education" class="mr-2">Highest Formal Education:</label>
                                            <select class="form-control" id="highest_formal_education" name="highest_formal_education_id" onchange="handleEducationSelect()" disabled  style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;">
                                                <option value="">Select Education Level</option>
                                                @foreach($highest_formal_education as $education)
                                                    <option value="{{ $education->id }}" {{ $farmersprofile->highest_formal_education_id == $education->id ? 'selected' : '' }}>
                                                        {{ $education->education }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-tooltip">
                                                Please select at least one option for Highest Formal Education.
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function handleEducationSelect() {
                                            var selectedEducationId = document.getElementById("highest_formal_education_id").value;
                                            // Add the CSRF token to the headers
                                            var csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

                                            // Example AJAX code using fetch API
                                            fetch('/get-education', {
method: 'POST',
headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken,
},
body: JSON.stringify({ educationId: selectedEducationId }),
})
                                            .then(response => response.json())
                                            .then(data => {
                                                // Handle the fetched data (update the page, display information, etc.).
                                                console.log(data);
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                            });
                                        }
                                    </script>






                <div class="col-md-6 position-relative mt-2">
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" value="{{ $farmersprofile->dob}}" disabled required>
                        <div class="invalid-tooltip">
                            Please enter your date of birth.
                        </div>
                    </div>
                </div>

                <div class="col-md-6 position-relative mt-2">
                    <div class="form-group">
                        <label for="pob">Place of Birth:</label>
                        <input type="text" class="form-control" id="pob" name="pob" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" value="{{ $farmersprofile->pob}}" disabled required>
                        <div class="invalid-tooltip">
                            Please enter your place of birth.
                        </div>
                    </div>
                </div>

                <div class="col-md-6 position-relative mt-2">
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" value="{{ $farmersprofile->religion}}" disabled required>
                        <div class="invalid-tooltip">
                            Please enter your religion.
                        </div>
                    </div>
                </div>

                <div class="col-md-3 position-relative mt-2">
                    <div class="form-inline">
                        <label for="pwd" class="mr-2">Person with Disability (PWD):</label>
                        @if($farmersprofile->pwd === 'Yes')
                            <div class="form-check form-check-inline">
                                <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="pwd" name="pwd" class="form-control" value="{{ $farmersprofile->pwd ?: 'N/A' }}" disabled>
                            </div>
                        @elseif($farmersprofile->pwd === 'No')
                            <div class="form-check form-check-inline">
                                <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="pwd" name="pwd" class="form-control" value="{{ $farmersprofile->pwd ?: 'N/A' }}" disabled>
                            </div>
                        @endif
                    </div>
                </div>





                <div class="col-md-3 position-relative mt-2">
                    <div class="form-group">
                        <label for="4ps" class="mr-2">4Ps Beneficiary:</label>
                        <div class="row">
                            @if($farmersprofile->benefits === 'Yes')
                                <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                    <div class="form-check">
                                        <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="pwd" name="pwd" class="form-control" value="{{ $farmersprofile->benefits ?: 'N/A' }}" disabled>
                                    </div>
                                </div>
                            @elseif($farmersprofile->benefits === 'No')
                                <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                    <div class="form-check">
                                        <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="pwd" name="pwd" class="form-control" value="{{ $farmersprofile->benefits ?: 'N/A' }}" disabled>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="invalid-tooltip">
                            Please select whether you are a 4Ps Beneficiary or not.
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-md-3 position-relative">
                        <div class="form-group">
                            <label for="cstatus">Civil Status:</label>
                            <select class="form-control" id="cstatus" name="civil_status_id" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;"
                                onchange="handleCivilStatusSelect()" disabled required>
                                <option value="">Select Civil Status</option>
                                @foreach($civilStatusOptions as $status)
                                <option value="{{ $status->id }}" {{ $farmersprofile->civil_status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                            </select>
                            <div class="invalid-tooltip">
                                Please select one option for Civil Status.
                            </div>
                        </div>
                    </div>
                    <script>
                        function handleCivilStatusSelect() {
                            var selectedStatusId = document.getElementById("civil_status_id").value;
                            // Add the CSRF token to the headers
                            var csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

                            // Example AJAX code using fetch API
                            fetch('/get-civil-status-data', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                    },
                                    body: JSON.stringify({
                                        civilstatusId: selectedStatusId
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Handle the fetched data (update the page, display information, etc.).
                                    console.log(data);
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }
                    </script>





                    <div class="col-md-3 position-relative mt-2">
                        <div class="form-group">
                            <label for="spouse">Name of Spouse if Married:</label>
                            <input type="text" class="form-control d-inline" id="spouse" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" name="spouse" value="{{ $farmersprofile->spouse ?: 'N/A' }}" disabled>
                            <div class="invalid-tooltip">
                                Please enter the name of your spouse if you are married.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 position-relative mt-2">
                        <div class="form-group">
                            <label for="emergency">Contact No. Incase of Emeergency</label>
                            <input type="number" class="form-control d-inline" id="emergency" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" name="emergency" value="{{ $farmersprofile-> emergency }}"
                                required disabled>
                            <div class="invalid-tooltip">
                                Please enter your Contact No. Incase of Emeergency.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 position-relative mt-2">
                        <div class="form-group">
                            <label for="mother">Mother's Maiden Name:</label>
                            <input type="text" class="form-control d-inline" id="mother" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" name="mother" value="{{ $farmersprofile-> mother }}"
                                required disabled>
                            <div class="invalid-tooltip">
                                Please enter your mother's maiden name.
                            </div>
                        </div>
                    </div>
                </div>


                <hr class="mt-2">
                <p class="mt-0" style="font-weight: bold; font-size: 12px;">PART II. FARMERS
                    PROFILE</p>

                <div class="col-md-12 mt-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="livelihood" class="mr-2">Main Livelihood:</label>
                                <div class="col-md-3 form-check form-check-inline">
                                    <input type="hidden" name="livelihood" value="Farmers">
                                    <input class="form-check-input" type="checkbox" name="livelihood" id="farmers" value="Farmers" checked disabled required
                                    @if($farmersprofile->livelihood === 'Farmers')
                                        checked
                                    @endif>
                                    <label class="form-check-label" for="farmers">Farmers</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validationCustom04" class="form-label fw-bold mt-2">For
                                Farmers</label>
                        </div>
                        <p class="mt-0" style="font-size: 12px;">Types of Farming Activity</p>
                    </div>
                </div>



                <div class="col-md-12">
                    <div class="row">
                        <div class="container">
                            <div class="row">
                                @foreach($farmers as $id => $farmer)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input crop-checkbox" type="checkbox" value="{{ $id }}" name="crops[{{ $id }}]"
                                            data-target="cropInputs{{ $id }}"
                                            @if($crops->contains('commodities_id', $id))
                                                checked
                                            @endif
                                        >
                                        <label class="form-check-label" for="farmer{{ $id }}">
                                            {{ $farmer }}
                                        </label>
                                    </div>
                                    <div class="commodity-inputs" id="cropInputs{{ $id }}">
                                        @forelse($crops->where('commodities_id', $id) as $crop)
                                            <div class="form-group">
                                                <label for="farmSize{{ $crop->commodities_id }}">Farm Size</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="farmSize{{ $crop->commodities_id }}" name="farm_size[{{ $crop->commodities_id }}]"
                                                    value="{{ $crop->farm_size }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="location{{ $crop->commodities_id }}">Location</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="location{{ $crop->commodities_id }}" name="farm_location[{{ $crop->commodities_id }}]"
                                                    value="{{ $crop->farm_location }}" disabled>
                                            </div>
                                        @empty
                                            <div class="form-group">
                                                <label for="farmSize{{ $id }}">Farm Size</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="farmSize{{ $id }}" name="farm_size[{{ $id }}]"
                                                    value="N/A" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="location{{ $id }}">Location</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="location{{ $id }}" name="farm_location[{{ $id }}]"
                                                    value="N/A" disabled>
                                            </div>
                                        @endforelse
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="row">
                        <div class="container">
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <label class="form-check-label mt-2" style="margin-left: -12px; font-weight: bold;" for="highValueCrops">High Value Crops</label>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($commodities as $id => $commodity)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input crop-checkbox" type="checkbox" value="{{ $id }}" name="crops[{{ $id }}]"
                                            data-target="cropInputs{{ $id }}" disabled
                                            @if($crops->contains('commodities_id', $id))
                                                checked
                                            @endif
                                        >
                                        <label class="form-check-label" for="commodity{{ $id }}">
                                            {{ $commodity }}
                                        </label>
                                    </div>
                                    <div class="commodity-inputs" id="cropInputs{{ $id }}">
                                        @forelse($crops->where('commodities_id', $id) as $crop)
                                            <div class="form-group">
                                                <label for="farmSize{{ $crop->commodities_id }}">Farm Size</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="farmSize{{ $crop->commodities_id }}" name="farm_size[{{ $crop->commodities_id }}]"
                                                    value="{{ $crop->farm_size }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="location{{ $crop->commodities_id }}">Location</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="location{{ $crop->commodities_id }}" name="farm_location[{{ $crop->commodities_id }}]"
                                                    value="{{ $crop->farm_location }}" disabled>
                                            </div>
                                        @empty
                                            <div class="form-group">
                                                <label for="farmSize{{ $id }}">Farm Size</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="farmSize{{ $id }}" name="farm_size[{{ $id }}]"
                                                    value="N/A" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="location{{ $id }}">Location</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="location{{ $id }}" name="farm_location[{{ $id }}]"
                                                    value="N/A" disabled>
                                            </div>
                                        @endforelse
                                    </div>

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="container">
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <label class="form-check-label mt-2"
                                        style="margin-left: -12px; font-weight: bold;"
                                        for="highValueCrops">Others</label>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($others as $id => $other)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input crop-checkbox" type="checkbox" value="{{ $id }}" name="crops[{{ $id }}]"
                                            data-target="cropInputs{{ $id }}" disabled
                                            @if($crops->contains('commodities_id', $id))
                                                checked
                                            @endif
                                        >
                                        <label class="form-check-label" for="commodity{{ $id }}">
                                            {{ $other }}
                                        </label>
                                    </div>
                                    <div class="commodity-inputs" id="cropInputs{{ $id }}">
                                        @forelse($crops->where('commodities_id', $id) as $crop)
                                            <div class="form-group">
                                                <label for="farmSize{{ $crop->commodities_id }}">Farm Size</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="farmSize{{ $crop->commodities_id }}" name="farm_size[{{ $crop->commodities_id }}]"
                                                    value="{{ $crop->farm_size }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="location{{ $crop->commodities_id }}">Location</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="location{{ $crop->commodities_id }}" name="farm_location[{{ $crop->commodities_id }}]"
                                                    value="{{ $crop->farm_location }}" disabled>
                                            </div>
                                        @empty
                                            <div class="form-group">
                                                <label for="farmSize{{ $id }}">Farm Size</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="farmSize{{ $id }}" name="farm_size[{{ $id }}]"
                                                    value="N/A" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="location{{ $id }}">Location</label>
                                                <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="location{{ $id }}" name="farm_location[{{ $id }}]"
                                                    value="N/A" disabled>
                                            </div>
                                        @endforelse
                                    </div>

                                </div>
                                @endforeach
                            </div>
            </div>
        </div>
    </div>

                <script>
                    $(document).ready(function() {
                        $('#highValueCrops').on('change', function() {
                            var isChecked = $(this).prop('checked');
                            $('.crop-checkbox').prop('disabled', !isChecked);
                            if (!isChecked) {
                                $('.commodity-inputs input').prop('disabled', true);
                            }
                        });

                        $('.crop-checkbox').on('change', function() {
                            var isChecked = $(this).prop('checked');
                            var inputsContainer = $('#' + $(this).data('target'));
                            inputsContainer.find('input').prop('disabled', !isChecked);
                        });
                    });
                </script>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="container">
                                        <div class="col-md-4">
                                            <label for="validationCustom04" class="form-label fw-bold mt-2">For Machineries</label>
                                        </div>
                                        <div class="row">
                                            @php $machineCount = 0; @endphp
                                            @foreach ($machine as $id => $machineName)
                                                @if ($machineCount % 3 === 0)
                                                    </div>
                                                    <div class="row">
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="machine_{{ $id }}" name="machineries[{{ $id }}]"
                                                            value="{{ $id }}" data-target="noofunits_{{ $id }}"
                                                            @if($machineries->contains('machine_id', $id))
                                                                checked
                                                            @endif
                                                            disabled>
                                                        <label class="form-check-label" for="machine_{{ $id }}">{{ $machineName }}</label>
                                                    </div>
                                                    @forelse($machineries->where('machine_id', $id) as $machine)
                                                        <div class="form-group">
                                                            <label for="units{{ $machine->machine_id }}">No. of Units</label>
                                                            <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="units{{ $machine->machine_id }}" name="units[{{ $machine->machine_id }}]"
                                                                value="{{ $machine->units }}" disabled>
                                                        </div>
                                                    @empty
                                                        <div class="form-group">
                                                            <label for="units{{ $id }}">No. of Units</label>
                                                            <input type="text" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="units{{ $id }}" name="units[{{ $id }}]"
                                                                value="N/A" disabled>
                                                        </div>
                                                    @endforelse
                                                </div>

                                                @php $machineCount++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                    {{-- <script>
                        $(document).ready(function() {
                            $('.form-check-input').on('change', function() {
                                var targetInputId = $(this).data('target');
                                var unitsInput = $('#' + targetInputId);

                                if ($(this).prop('checked')) {
                                    unitsInput.prop('disabled', false);
                                } else {
                                    unitsInput.prop('disabled', true);
                                }
                            });
                        });
                    </script> --}}



                            <!-- resources/views/livewire/income-form.blade.php -->
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="validationCustom01" class="form-label">Gross Annual Income Last
                                        Year:</label>
                                    <div class="d-flex align-items-center">
                                        <label class="me-2">Farming</label>
                                        <input type="number" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationCustom01" name="gross" value="{{ $farmersprofile->gross}}" disabled required>
                                        <label class="ms-3 me-2">Non-Farming</label>
                                        <input type="number" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationCustom02" name="grosses" value="{{ $farmersprofile->grosses}}" disabled required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide the gross annual income for both farming and non-farming.
                                    </div>
                                </div>
                            </div>

                            <!-- resources/views/livewire/farm-parcels-form.blade.php -->
                            <div class="col-md-8 mt-3">
                                <label class="form-label">No. of Farm Parcels</label>
                                <input type="number" style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;" class="form-control" id="validationTooltip01" required
                                name="parcels" value="{{ $farmersprofile->parcels}}" disabled autofocus>
                                <div class="invalid-tooltip">
                                    Please provide the number of farm parcels.
                                </div>
                            </div>


                            <!-- resources/views/livewire/agrarian-reform-form.blade.php -->
                            <div class="col-md-4 position-relative mt-4">
                                <div class="form-group">
                                    <label for="arb" class="mr-2">Agrarian Reform Beneficiaries:</label>
                                    <div class="row">
                                        @if($farmersprofile->arb === 'Yes')
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="pwd" name="arb" class="form-control" value="{{ $farmersprofile->arb ?: 'N/A' }}" disabled>
                                                </div>
                                            </div>
                                        @elseif($farmersprofile->arb === 'No')
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input type="text" style="border-bottom: solid 1px; border-radius: 0; border-top: none; border-left: none; border-right: none;" id="pwd" name="arb" class="form-control" value="{{ $farmersprofile->arb ?: 'N/A' }}" disabled>
                                    </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please select if you are an Agrarian Reform Beneficiary.
                                    </div>
                                </div>
                            </div>


                        </form>
                        </div>
                    </div>
                </div>
@endsection

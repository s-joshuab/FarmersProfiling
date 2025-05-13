@extends('layouts.index')
@section('content')
    <title>Add Farmers</title>

    <div class="col-12 mb-2 d-flex justify-content-end">
        <button type="reset" class="btn btn-success" id="backBtn">Back</button>
    </div>
    <script>
        document.getElementById("backBtn").onclick = function() {
            // Go back to the previous page
            window.history.back();
        };
    </script>

    <div class="row">
        <div class="container">
            <div class="col-lg-12">
                <form action="{{ url('store') }}" method="post">
                    @csrf
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
                                        <label for="referenceNo" class="mr-2">Reference/Control No.: </label>
                                        <div class="flex-grow-1">
                                            <input type="number" class="form-control d-inline" id="ref_no" name="ref_no" readonly>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    const refNoInput = document.getElementById('ref_no');

                                    // Generate a random 15-digit number and insert it into the input field
                                    function generateRandomNumber() {
                                        let randomNumber = Math.floor(100000000000000 + Math.random() * 900000000000000);
                                        refNoInput.value = randomNumber;
                                    }

                                    // Generate a random number when the page loads
                                    window.addEventListener('load', generateRandomNumber);
                                </script>

                                <div class="col-md-6 position-relative mt-3">
                                    <label class="form-label">Status</label>
                                    <div class="col-sm-12">
                                        <select class="form-select" aria-label="Default select example"
                                            id="validationTooltip03" name="status" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <div id='statusValidationFeedback' class="invalid-feedback">
                                            Please select the status.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const statusSelect = document.getElementById('validationTooltip03');
                                    const statusValidationFeedback = document.getElementById('statusValidationFeedback');

                                    // Show validation message initially
                                    statusValidationFeedback.style.display = 'block';

                                    statusSelect.addEventListener('change', function() {
                                        const selectedStatus = this.value;

                                        if (selectedStatus !== '') {
                                            statusValidationFeedback.style.display = 'none';
                                        } else {
                                            statusValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>



                                <hr class="mt-2">
                                <p class="mt-0" style="font-weight: bold; font-size: 12px;">PART I. PERSONAL INFORMATION
                                </p>

                                <!-- Surname Field -->
                                <div class="col-md-6 position-relative mt-0">
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control is-invalid" id="validationTooltipSurname"
                                        name="sname" required autofocus="autofocus">
                                    <div class="invalid-feedback">
                                        Please enter your surname.
                                    </div>
                                </div>

                                <!-- Validation Script for Surname -->
                                <script>
                                    document.getElementById('validationTooltipSurname').addEventListener('input', function() {
                                        const surnameInput = this;
                                        const feedbackDiv = surnameInput
                                        .nextElementSibling; // Assuming the feedback div is the next sibling element

                                        if (surnameInput.value.trim() !== '') {
                                            surnameInput.classList.remove('is-invalid');
                                            feedbackDiv.style.display = 'none';
                                        } else {
                                            surnameInput.classList.add('is-invalid');
                                            feedbackDiv.style.display = 'block';
                                        }
                                    });
                                </script>

                                <!-- First Name Field -->
                                <div class="col-md-6 position-relative mt-0">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control is-invalid" id="validationTooltipFirstName"
                                        name="fname" required autofocus="autofocus">
                                    <div class="invalid-feedback">
                                        The First Name field is required.
                                    </div>
                                </div>

                                <!-- Validation Script for First Name -->
                                <script>
                                    document.getElementById('validationTooltipFirstName').addEventListener('input', function() {
                                        const firstNameInput = this;
                                        const feedbackDiv = firstNameInput
                                        .nextElementSibling; // Assuming the feedback div is the next sibling element

                                        if (firstNameInput.value.trim() !== '') {
                                            firstNameInput.classList.remove('is-invalid');
                                            feedbackDiv.style.display = 'none';
                                        } else {
                                            firstNameInput.classList.add('is-invalid');
                                            feedbackDiv.style.display = 'block';
                                        }
                                    });
                                </script>

                                <!-- Middle Name Field -->
                                <div class="col-md-5 position-relative mt-0">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control"
                                        name="mname" >

                                </div>


                                <!-- Extension Name Field -->
                                <div class="col-md-3 position-relative mt-0">
                                    <label class="form-label">Extension Name</label>
                                    <input type="text" class="form-control" id="validationTooltipExtensionName"
                                        name="ename" autofocus="autofocus">
                                </div>

                                <!-- Sex Radio Buttons -->
                                <div class="col-md-4 position-relative" style="margin-top: 35px;">
                                    <div class="form-inline">
                                        <label for="sex" class="mr-2">Sex:</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sex" id="maleOption"
                                                value="Male" required>
                                            <label class="form-check-label" for="maleOption">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sex" id="femaleOption"
                                                value="Female" required>
                                            <label class="form-check-label" for="femaleOption">Female</label>
                                        </div>
                                        <!-- Validation for Sex Radio Buttons -->
                                        <div id="sexValidationFeedback" class="invalid-feedback">
                                            Please select a gender.
                                        </div>
                                    </div>
                                </div>

                                <!-- Validation Script for Sex Radio Buttons -->
                                <!-- Validation Script for Sex Radio Buttons -->
                                <script>
                                    const sexContainer = document.querySelector('.form-inline');
                                    const sexOptions = sexContainer.querySelectorAll('[name="sex"]');
                                    const sexValidationFeedback = document.getElementById('sexValidationFeedback');

                                    // Show validation message initially
                                    sexValidationFeedback.style.display = 'block';

                                    sexContainer.addEventListener('change', function() {
                                        const isMaleSelected = document.getElementById('maleOption').checked;
                                        const isFemaleSelected = document.getElementById('femaleOption').checked;

                                        if (isMaleSelected || isFemaleSelected) {
                                            sexValidationFeedback.style.display = 'none';
                                        } else {
                                            sexValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>




                                <hr class="mt-2">
                                <p class="mt-0" style="font-weight:bold; font-size: 12px;">ADDRESS</p>
                                <div class="col-md-4 position-relative mt-0">
                                    <label for="Region">Region</label>
                                    <div class="form-control-custom">
                                        <input type="text"
                                            style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;"
                                            id="regions" name="regions" class="form-control" value="Region I"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-4 position-relative mt-0">
                                    <label for="province">Province:</label>
                                    <div class="form-control-custom">
                                        <input type="text"
                                            style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;"
                                            id="provinces_id" name="provinces_id" class="form-control" value="La Union"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-4 position-relative mt-0">
                                    <label for="municipality">Municipality:</label>
                                    <div class="form-control-custom">
                                        <input type="text" id="provinces_id"
                                            style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;"
                                            name="municipalities_id" class="form-control" value="Balaoan" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4 position-relative mt-2">
                                    <label for="barangay">Barangay:</label>
                                    <select id="barangay" name="barangays_id" class="form-control" required>
                                        <option value="">Select Barangay</option>
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay->id }}">{{ $barangay->barangays }}</option>
                                        @endforeach
                                    </select>
                                    <div id="barangayValidationFeedback" class="invalid-feedback">
                                        Please select a Barangay.
                                    </div>
                                </div>

                                <!-- Validation Script for Barangay Dropdown -->
                                <script>
                                    const barangaySelect = document.getElementById('barangay');
                                    const barangayValidationFeedback = document.getElementById('barangayValidationFeedback');

                                    // Show validation message initially
                                    barangayValidationFeedback.style.display = 'block';

                                    barangaySelect.addEventListener('change', function() {
                                        const selectedOption = this.value;

                                        if (selectedOption !== '') {
                                            barangayValidationFeedback.style.display = 'none';
                                        } else {
                                            barangayValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>


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



                                <div class="col-md-4 position-relative mt-0">
                                    <label class="form-label">Street/Sitio/Purok/Subdv.</label>
                                    <input type="text" class="form-control" id="validationTooltip01" name="purok"
                                        autofocus="autofocus">
                                    <div class="invalid-tooltip">
                                        The Street/Sitio/Purok/Subdv. field is required.
                                    </div>
                                </div>

                                <div class="col-md-4 position-relative mt-0">
                                    <label class="form-label">House/Lot/Bldg. No.</label>
                                    <input type="text" class="form-control" id="validationTooltip01" name="house"
                                        autofocus="autofocus">
                                    <div class="invalid-tooltip">
                                        The House/Lot/Bldg. No. field is required.
                                    </div>
                                </div>

                                <hr class="mt-2">


                                <div class="col-md-6 position-relative mt-0">
                                    <label class="form-label">Contact Number</label>
                                    <input type="number" class="form-control d-inline" id="number" name="number"
                                        oninput="javascript: if (this.value.length > 11) this.value = this.value.slice(0, 11);"
                                        required>
                                    <div id="numberValidationFeedback" class="invalid-feedback">
                                        Please enter a valid contact number (maximum 11 digits).
                                    </div>
                                </div>
                                <script>
                                    const contactNumberInput = document.getElementById('number');
                                    const contactNumberValidationFeedback = document.getElementById('numberValidationFeedback');

                                    // Show validation message initially
                                    contactNumberValidationFeedback.style.display = 'block';

                                    contactNumberInput.addEventListener('input', function() {
                                        const inputValue = this.value;

                                        if (inputValue.length <= 11) {
                                            contactNumberValidationFeedback.style.display = 'none';
                                        } else {
                                            contactNumberValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>

                                <div class="col-md-6 position-relative mt-0">
                                    <div class="form-group">
                                        <label for="highest_formal_education" class="mr-2">Highest Formal
                                            Education:</label>
                                        <select class="form-control" id="highest_formal_education"
                                            name="highest_formal_education_id" onchange="handleEducationSelect()">
                                            <option value="">Select Education Level</option>
                                            @foreach ($highest_formal_education as $education)
                                                <option value="{{ $education->id }}">{{ $education->education }}</option>
                                            @endforeach
                                        </select>
                                        <div id="educationValidationFeedback" class="invalid-feedback">
                                            Please select the highest formal education level.
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    const educationSelect = document.getElementById('highest_formal_education');
                                    const educationValidationFeedback = document.getElementById('educationValidationFeedback');

                                    // Show validation message initially
                                    educationValidationFeedback.style.display = 'block';

                                    educationSelect.addEventListener('change', function() {
                                        const selectedEducationId = this.value;

                                        if (selectedEducationId !== '') {
                                            educationValidationFeedback.style.display = 'none';
                                        } else {
                                            educationValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>
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
                                                body: JSON.stringify({
                                                    educationId: selectedEducationId
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





                                <div class="col-md-6 position-relative mt-2">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth:</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                            required>
                                        <div id='dobValidationFeedback' class="invalid-feedback">
                                            Please enter your date of birth.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const dobInput = document.getElementById('dob');
                                    const dobValidationFeedback = document.getElementById('dobValidationFeedback');

                                    // Show validation message initially
                                    dobValidationFeedback.style.display = 'block';

                                    dobInput.addEventListener('input', function() {
                                        const inputValue = this.value;

                                        if (inputValue !== '') {
                                            dobValidationFeedback.style.display = 'none';
                                        } else {
                                            dobValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>

                                <div class="col-md-6 position-relative mt-2">
                                    <div class="form-group">
                                        <label for="pob">Place of Birth:</label>
                                        <input type="text" class="form-control" id="pob" name="pob"
                                            required>
                                        <div id='pobValidationFeedback' class="invalid-feedback">
                                            Please enter your place of birth.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const pobInput = document.getElementById('pob');
                                    const pobValidationFeedback = document.getElementById('pobValidationFeedback');

                                    // Show validation message initially
                                    pobValidationFeedback.style.display = 'block';

                                    pobInput.addEventListener('input', function() {
                                        const inputValue = this.value;

                                        if (inputValue !== '') {
                                            pobValidationFeedback.style.display = 'none';
                                        } else {
                                            pobValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>

                                <div class="col-md-6 position-relative mt-2">
                                    <div class="form-group">
                                        <label for="religion">Religion</label>
                                        <input type="text" class="form-control" id="religion" name="religion"
                                            required>
                                        <div id='religionValidationFeedback' class="invalid-feedback">
                                            Please enter your religion.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const religionInput = document.getElementById('religion');
                                    const religionValidationFeedback = document.getElementById('religionValidationFeedback');

                                    // Show validation message initially
                                    religionValidationFeedback.style.display = 'block';

                                    religionInput.addEventListener('input', function() {
                                        const inputValue = this.value;

                                        if (inputValue !== '') {
                                            religionValidationFeedback.style.display = 'none';
                                        } else {
                                            religionValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>

                                <div class="col-md-3 position-relative mt-2">
                                    <div class="form-group">
                                        <label for="pwd" class="mr-2">Person with Disability (PWD):</label>
                                        <div class="row">
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="pwdYes"
                                                        name="pwd" value="Yes" required>
                                                    <label class="form-check-label" for="pwdYes">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="pwdNo"
                                                        name="pwd" value="No" required>
                                                    <label class="form-check-label" for="pwdNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='pwdValidationFeedback' class="invalid-feedback">
                                            Please select whether you are a Person with Disability (PWD) or not.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const pwdOptions = document.querySelectorAll('[name="pwd"]');
                                    const pwdValidationFeedback = document.getElementById('pwdValidationFeedback');

                                    // Show validation message initially
                                    pwdValidationFeedback.style.display = 'block';

                                    pwdOptions.forEach(function(option) {
                                        option.addEventListener('change', function() {
                                            const isYesSelected = document.getElementById('pwdYes').checked;
                                            const isNoSelected = document.getElementById('pwdNo').checked;

                                            if (isYesSelected || isNoSelected) {
                                                pwdValidationFeedback.style.display = 'none';
                                            } else {
                                                pwdValidationFeedback.style.display = 'block';
                                            }
                                        });
                                    });
                                </script>


                                <div class="col-md-3 position-relative mt-2">
                                    <div class="form-group">
                                        <label for="4ps" class="mr-2">4Ps Beneficiary:</label>
                                        <div class="row">
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="beneficiaryYes"
                                                        name="benefits" value="Yes" required>
                                                    <label class="form-check-label" for="beneficiaryYes">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="beneficiaryNo"
                                                        name="benefits" value="No" required>
                                                    <label class="form-check-label" for="beneficiaryNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='beneficiaryValidationFeedback' class="invalid-feedback">
                                            Please select whether you are a 4Ps Beneficiary or not.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const beneficiaryOptions = document.querySelectorAll('[name="benefits"]');
                                    const beneficiaryValidationFeedback = document.getElementById('beneficiaryValidationFeedback');

                                    // Show validation message initially
                                    beneficiaryValidationFeedback.style.display = 'block';

                                    beneficiaryOptions.forEach(function(option) {
                                        option.addEventListener('change', function() {
                                            const isYesSelected = document.getElementById('beneficiaryYes').checked;
                                            const isNoSelected = document.getElementById('beneficiaryNo').checked;

                                            if (isYesSelected || isNoSelected) {
                                                beneficiaryValidationFeedback.style.display = 'none';
                                            } else {
                                                beneficiaryValidationFeedback.style.display = 'block';
                                            }
                                        });
                                    });
                                </script>


                           <div class="row">
                                    <div class="col-md-3 position-relative">
                                        <div class="form-group">
                                            <label for="cstatus">Civil Status:</label>
                                            <select class="form-control" id="cstatus" name="civil_status_id"
                                                onchange="handleCivilStatusSelect()" required>
                                                <option value="">Select Civil Status</option>
                                                @foreach ($civilStatusOptions as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ $status->civil_status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id='civilStatusValidationFeedback' class="invalid-feedback">
                                                Please select your civil status.
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const civilStatusSelect = document.getElementById('cstatus');
                                        const civilStatusValidationFeedback = document.getElementById('civilStatusValidationFeedback');

                                        // Show validation message initially
                                        civilStatusValidationFeedback.style.display = 'block';

                                        civilStatusSelect.addEventListener('change', function() {
                                            const selectedCivilStatus = this.value;

                                            if (selectedCivilStatus !== '') {
                                                civilStatusValidationFeedback.style.display = 'none';
                                            } else {
                                                civilStatusValidationFeedback.style.display = 'block';
                                            }
                                        });
                                    </script>

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
                                            <label for="emergency">Name of Spouse if Married:</label>
                                            <input type="text" class="form-control d-inline" id="spouse"
                                                name="spouse">
                                        </div>
                                        </div>

                                    <div class="col-md-3 position-relative mt-2">
                                        <div class="form-group">
                                            <label for="mother">Mother's Maiden Name:</label>
                                            <input type="text" class="form-control d-inline" id="mother"
                                                name="mother" required>
                                            <div id='motherValidationFeedback' class="invalid-feedback">
                                                Please enter your mother's maiden name.
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const motherInput = document.getElementById('mother');
                                        const motherValidationFeedback = document.getElementById('motherValidationFeedback');

                                        // Show validation message initially
                                        motherValidationFeedback.style.display = 'block';

                                        motherInput.addEventListener('input', function() {
                                            const inputValue = this.value;

                                            if (inputValue !== '') {
                                                motherValidationFeedback.style.display = 'none';
                                            } else {
                                                motherValidationFeedback.style.display = 'block';
                                            }
                                        });
                                    </script>

                                    <div class="col-md-3 position-relative mt-2">
                                        <div class="form-group">
                                            <label for="emergency">Contact No. Incase of Emergency</label>
                                            <input type="number" class="form-control d-inline" id="emergency"
                                                name="emergency"
                                                oninput="javascript: if (this.value.length > 11) this.value = this.value.slice(0, 11);"
                                                required>


                                            <div id='emergencyValidationFeedback' class="invalid-feedback">
                                                Please enter a valid emergency contact number (maximum 11 digits).
                                            </div>

                                        </div>
                                    </div>
                                    <script>
                                        const emergencyInput = document.getElementById('emergency');
                                        const emergencyValidationFeedback = document.getElementById('emergencyValidationFeedback');

                                        // Show validation message initially
                                        emergencyValidationFeedback.style.display = 'block';

                                        emergencyInput.addEventListener('input', function() {
                                            const inputValue = this.value;

                                            if (inputValue.length <= 11) {
                                                emergencyValidationFeedback.style.display = 'none';
                                            } else {
                                                emergencyValidationFeedback.style.display = 'block';
                                            }
                                        });
                                    </script>


                                </div>



                                <hr class="mt-2">
                                <p class="mt-0" style="font-weight: bold; font-size: 12px;">PART II. FARMERS
                                    PROFILE</p>

                                <div class="col-md-12 mt-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="livelihood" class="mr-2">Main Livelihood:</label>
                                                <div class="col-md-3 form-check form-check-inline">
                                                    <!-- Make it a form-control -->
                                                    <input type="text"
                                                        style="border-bottom:solid 1px; border-radius:0; border-top: none; border-left: none; border-right: none;"
                                                        id="Farmers" name="livelihood" class="form-control"
                                                        value="Farmers" readonly>
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
                                                @foreach ($farmers as $id => $farmer)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input crop-checkbox farmer-checkbox"
                                                                type="checkbox" value="{{ $id }}"
                                                                id="crops[{{ $id }}]"
                                                                name="crops[{{ $id }}]"
                                                                data-target="cropInputs{{ $id }}">
                                                            <label class="form-check-label"
                                                                for="farmer{{ $id }}">
                                                                {{ $farmer }}
                                                            </label>
                                                        </div>
                                                        <div class="commodity-inputs" id="cropInputs{{ $id }}">
                                                            <div class="form-group">
                                                                <label for="farmSize{{ $id }}">Farm Size</label>
                                                                <input type="text" class="form-control farm-size-input"
                                                                    id="farmSize{{ $id }}"
                                                                    name="farm_size[{{ $id }}] <span>ha</span>"
                                                                    disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="location{{ $id }}">Location</label>
                                                                <input type="text" class="form-control location-input"
                                                                    id="location{{ $id }}"
                                                                    name="farm_location[{{ $id }}]" disabled>
                                                            </div>
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
                                                        for="highValueCrops">High Value Crops</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($commodities as $id => $commodity)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input crop-checkbox" type="checkbox"
                                                                value="{{ $id }}"
                                                                id="crops[{{ $id }}]"
                                                                name="crops[{{ $id }}]"
                                                                data-target="cropInputs{{ $id }}">
                                                            <label class="form-check-label"
                                                                for="commodity{{ $id }}">
                                                                {{ $commodity }}
                                                            </label>
                                                        </div>
                                                        <div class="commodity-inputs" id="cropInputs{{ $id }}">
                                                            <div class="form-group">
                                                                <label for="farmSize{{ $id }}">Farm Size</label>
                                                                <input type="text" class="form-control"
                                                                    id="farmSize{{ $id }}"
                                                                    name="farm_size[{{ $id }}]" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="location{{ $id }}">Location</label>
                                                                <input type="text" class="form-control"
                                                                    id="location{{ $id }}"
                                                                    name="farm_location[{{ $id }}]" disabled>
                                                            </div>
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
                                                @foreach ($others as $id => $other)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input crop-checkbox" type="checkbox"
                                                                value="{{ $id }}"
                                                                id="crops[{{ $id }}]"
                                                                name="crops[{{ $id }}]"
                                                                data-target="cropInputs{{ $id }}">
                                                            <label class="form-check-label"
                                                                for="commodity{{ $id }}">
                                                                {{ $other }}
                                                            </label>
                                                        </div>
                                                        <div class="commodity-inputs" id="cropInputs{{ $id }}">
                                                            <div class="form-group">
                                                                <label for="farmSize{{ $id }}">Farm Size</label>
                                                                <input type="text" class="form-control"
                                                                    id="farmSize{{ $id }}"
                                                                    name="farm_size[{{ $id }}]" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="location{{ $id }}">Location</label>
                                                                <input type="text" class="form-control"
                                                                    id="location{{ $id }}"
                                                                    name="farm_location[{{ $id }}]" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="others">Others</label>
                                        <input type="text" class="form-control farm-size-input" id="others" name="commodities_id">
                                    </div>

                                    <div class="commodity-inputs" id="cropInputs">
                                        <div class="form-group">
                                            <label for="farmSize">Farm Size</label>
                                            <input type="text" class="form-control farm-size-input" id="farmSize" name="farm_size" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="location">Location</label>
                                            <input type="text" class="form-control location-input" id="location" name="farm_location" disabled>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Get the "Others" input element
                                    var othersInput = document.getElementById('others');

                                    // Get the "Farm Size" and "Location" input elements
                                    var farmSizeInput = document.getElementById('farmSize');
                                    var locationInput = document.getElementById('location');

                                    // Add an event listener to the "Others" input to check for changes
                                    othersInput.addEventListener('input', function () {
                                        // Generate a unique identifier
                                        var uniqueId = 'others_' + Date.now(); // Example: You might need a more robust solution

                                        // If "Others" input is not empty, enable the "Farm Size" and "Location" inputs
                                        if (othersInput.value.trim() !== '') {
                                            farmSizeInput.disabled = false;
                                            locationInput.disabled = false;

                                            // Assign the unique identifier to the disabled inputs
                                            farmSizeInput.name = uniqueId + '_farm_size';
                                            locationInput.name = uniqueId + '_farm_location';
                                        } else {
                                            // If "Others" input is empty, disable the "Farm Size" and "Location" inputs
                                            farmSizeInput.disabled = true;
                                            locationInput.disabled = true;

                                            // Reset the name attributes
                                            farmSizeInput.name = 'farm_size';
                                            locationInput.name = 'farm_location';
                                        }
                                    });
                                </script> --}}



                                <script>
                                    $(document).ready(function() {
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
                                                <label for="validationCustom04" class="form-label fw-bold mt-2">For
                                                    Machineries</label>
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
                                                        <input class="form-check-input machinery-checkbox" type="checkbox"
                                                            id="machine_{{ $id }}"
                                                            name="machineries[{{ $id }}]"
                                                            value="{{ $id }}"
                                                            data-target="noofunits_{{ $id }}">
                                                        <label class="form-check-label"
                                                            for="machine_{{ $id }}">{{ $machineName }}</label>
                                                    </div>
                                                    <label for="noofunits_{{ $id }}" class="form-label">No. Of
                                                        Units:</label>
                                                    <input type="number" class="form-control units-input"
                                                        id="noofunits_{{ $id }}"
                                                        name="units[{{ $id }}]" disabled>
                                                </div>
                                                @php $machineCount++; @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                <script>
                                    jQuery(document).ready(function($) {
                                        $('.machinery-checkbox').on('change', function() {
                                            var checkboxId = $(this).attr('id');
                                            var unitsInputId = 'noofunits_' + checkboxId.split('_')[1];
                                            var unitsInput = $('#' + unitsInputId);

                                            if ($(this).prop('checked')) {
                                                unitsInput.prop('disabled', false);
                                                unitsInput.val(1);
                                            } else {
                                                unitsInput.prop('disabled', true);
                                                unitsInput.val('');
                                            }
                                        });
                                    });
                                </script>




                                <!-- resources/views/livewire/income-form.blade.php -->
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label for="validationCustom01" class="form-label">Gross Annual Income Last
                                            Year:</label>
                                        <div class="d-flex align-items-center">
                                            <label class="me-2">Farming</label>
                                            <input type="number" class="form-control" id="gross"
                                                id="validationCustom01" name="gross" maxlength="7" required>
                                            <label class="ms-3 me-2">Non-Farming</label>
                                            <input type="number" class="form-control" id="grosses"
                                                id="validationCustom02" name="grosses" maxlength="7" required>
                                        </div>
                                        <div id='grossIncomeValidationFeedback' class="invalid-feedback">
                                            Please enter gross annual income in Farming and Non-Farming.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const grossIncomeInput = document.getElementById('gross');
                                    const nonFarmingIncomeInput = document.getElementById('grosses');
                                    const grossIncomeValidationFeedback = document.getElementById('grossIncomeValidationFeedback');

                                    // Show validation message initially
                                    grossIncomeValidationFeedback.style.display = 'block';

                                    // Listen for input events on both fields
                                    grossIncomeInput.addEventListener('input', validateGrossIncome);
                                    nonFarmingIncomeInput.addEventListener('input', validateGrossIncome);

                                    function validateGrossIncome() {
                                        const grossIncome = grossIncomeInput.value.trim();
                                        const nonFarmingIncome = nonFarmingIncomeInput.value.trim();

                                        if (grossIncome !== '' || nonFarmingIncome !== '') {
                                            grossIncomeValidationFeedback.style.display = 'none';
                                        } else {
                                            grossIncomeValidationFeedback.style.display = 'block';
                                        }
                                    }
                                </script>

                                <!-- resources/views/livewire/farm-parcels-form.blade.php -->
                                <div class="col-md-8 mt-3">
                                    <label class="form-label">No. of Farm Parcels</label>
                                    <input type="number" class="form-control" id="parcels" id="validationTooltip01"
                                        maxlength="15" required name="parcels">
                                    <div id='parcelsValidationFeedback' class="invalid-feedback">
                                        Please enter the number of farm parcels.
                                    </div>
                                </div>
                                <script>
                                    const parcelsInput = document.getElementById('parcels');
                                    const parcelsValidationFeedback = document.getElementById('parcelsValidationFeedback');

                                    // Show validation message initially
                                    parcelsValidationFeedback.style.display = 'block';

                                    parcelsInput.addEventListener('input', function() {
                                        const inputValue = this.value.trim();

                                        if (inputValue !== '') {
                                            parcelsValidationFeedback.style.display = 'none';
                                        } else {
                                            parcelsValidationFeedback.style.display = 'block';
                                        }
                                    });
                                </script>


                                <!-- resources/views/livewire/agrarian-reform-form.blade.php -->
                                <div class="col-md-4 position-relative mt-4">
                                    <div class="form-group">
                                        <label for="pwd" class="mr-2">Agrarian Reform Beneficiaries:</label>
                                        <div class="row">
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="pwdYes"
                                                        name="arb" value="Yes" required>
                                                    <label class="form-check-label" for="pwdYes">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1" style="margin-left: 10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="pwdNo"
                                                        name="arb" value="No" required>
                                                    <label class="form-check-label" for="pwdNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='arbValidationFeedback' class="invalid-feedback">
                                            Please select whether you are an Agrarian Reform Beneficiary or not.
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const arbOptions = document.querySelectorAll('[name="arb"]');
                                    const arbValidationFeedback = document.getElementById('arbValidationFeedback');

                                    // Show validation message initially
                                    arbValidationFeedback.style.display = 'block';

                                    arbOptions.forEach(function(option) {
                                        option.addEventListener('change', function() {
                                            const isYesSelected = document.getElementById('pwdYes').checked;
                                            const isNoSelected = document.getElementById('pwdNo').checked;

                                            if (isYesSelected || isNoSelected) {
                                                arbValidationFeedback.style.display = 'none';
                                            } else {
                                                arbValidationFeedback.style.display = 'block';
                                            }
                                        });
                                    });
                                </script>




                                {{-- <hr class="mt-5">

                                <label class="form-check-label" for="termsCheck">
                                    <input class="form-check-input mr-2 text-center" type="checkbox" id="termsCheck"
                                        required>
                                    I hereby declare that all information indicated above is true and
                                    correct,
                                    and that they may be used by Municipal Agriculurist Office of
                                    Balaoan, La
                                    Union for the purposes of registration to the Registry System for
                                    Basic
                                    Sectors in Agriculture (RSBSA) and other legitimate interests of the
                                    Department pursuant to its mandates.
                                </label>
                                <div class="invalid-tooltip">
                                    Please accept the declaration to proceed.
                                </div>



                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <textarea class="form-control" disabled style= "height: 120px;"></textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control" disabled style="height: 120px;"></textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control" disabled style="height: 120px;"></textarea>
                                            </td>
                                            <td>
                                                <textarea class="form-control" disabled style="height: 120px;"></textarea>
                                            </td>
                                        </tr>

                                    <tfoot style="text-align: center;">
                                        <tr>
                                            <th>Date</th>
                                            <th>PRINTED NAME OF APPLICANT</th>
                                            <th>SIGNATURE OF APPLICANT</th>
                                            <th>THUMBMARK</th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table> --}}


                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end p-3">
                                            <div class="button-container">
                                                <button class="btn btn-primary submit-button" name="submit">Add</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add this to your admin.farmers.create view -->
@endsection

@include('layouts.header')
<div class="container mx-auto px-5 mt-5">

    <livewire:farmerstable/>

</div>



@livewireScripts
<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>


</html>



<div class="col-md-4 position-relative mt-0">
    <label for="province">Province:</label>
    <select id="province" name="provinces_id" class="form-control" required>
        <option value="">Select Province</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}">{{ $province->provinces }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-4 position-relative mt-0">
    <label for="municipality">Municipality:</label>
    <select id="municipality" name="municipalities_id" class="form-control" required>
        <option value="">Select Municipality</option>
    </select>
</div>

<div class="col-md-4 position-relative mt-2">
    <label for="barangay">Barangay:</label>
    <select id="barangay" name="barangays_id" class="form-control" required>
        <option value="">Select Barangay</option>
    </select>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script>


{{-- // VIEW --}}
<div class="col-md-4 position-relative mt-0">
    <label for="municipality">Municipality:</label>
    <select id="municipality" name="municipalities_id" class="form-control" disabled>
        <option value="">Select Municipality</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}" {{ $farmersprofile->provinces_id == $province->id ? 'selected' : '' }}>
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
            <option value="{{ $municipality->id }}" {{ $farmersprofile->municipalities_id == $municipality->id ? 'selected' : '' }}>
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
            <option value="{{ $barangay->id }}" {{ $farmersprofile->barangays_id == $barangay->id ? 'selected' : '' }}>
                {{ $barangay->barangays }}
            </option>
        @endforeach
    </select>
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


{{-- update --}}

<div class="col-md-4 position-relative mt-0">
    <label for="Region">Region</label>
    <div class="form-control-custom">
      <input type="text" id="regions" name="regions" class="form-control" value="Region I" disabled>
    </div>
  </div>



<!-- Beekeeper Province Address -->
<div class="col-md-4 position-relative mt-0">
    <label for="province">Province:</label>
    <select id="province" name="provinces_id" class="form-control" >
        <option value="">Select Province</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}" {{ $farmersprofile->provinces_id == $province->id ? 'selected' : '' }}>
                {{ $province->provinces }}
            </option>
        @endforeach
    </select>
</div>

<!-- Municipality Dropdown -->
<div class="col-md-4 position-relative mt-0">
    <label for="municipality">Municipality:</label>
    <select id="municipality" name="municipalities_id" class="form-control" >
        <option value="">Select Municipality</option>
        @foreach ($municipalities as $municipality)
            <option value="{{ $municipality->id }}" {{ $farmersprofile->municipalities_id == $municipality->id ? 'selected' : '' }}>
                {{ $municipality->municipalities }}
            </option>
        @endforeach
    </select>
</div>

<!-- Barangay Dropdown -->
<div class="col-md-4 position-relative mt-0">
    <label for="barangay">Barangay:</label>
    <select id="barangay" name="barangays_id" class="form-control" >
        <option value="">Select Barangay</option>
        @foreach ($barangays as $barangay)
            <option value="{{ $barangay->id }}" {{ $farmersprofile->barangays_id == $barangay->id ? 'selected' : '' }}>
                {{ $barangay->barangays }}
            </option>
        @endforeach
    </select>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script>

{{-- users view --}}

<div class="col-md-4 position-relative mt-0">
    <label for="municipality">Municipality:</label>
    <select id="municipality" name="provinces_id" class="form-control">
        <option value="">Select Municipality</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}"
                {{ $user->provinces_id == $province->id ? 'selected' : '' }}>
                {{ $province->provinces }}
            </option>
        @endforeach
    </select>
</div>

<!-- Municipality Dropdown -->
<div class="col-md-4 position-relative mt-0">
    <label for="municipality">Municipality:</label>
    <select id="municipality" name="municipalities_id" class="form-control" d>
        <option value="">Select Municipality</option>
        @foreach ($municipalities as $municipality)
            <option value="{{ $municipality->id }}"
                {{ $user->municipalities_id == $municipality->id ? 'selected' : '' }}>
                {{ $municipality->municipalities }}
            </option>
        @endforeach
    </select>
</div>

<!-- Barangay Dropdown -->
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
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                $('#municipality').append('<option value="' + municipality.id + '">' +
                    municipality.municipalities + '</option>');
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
                $('#barangay').append('<option value="' + barangay.id + '">' + barangay
                    .barangays + '</option>');
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
</script>


{{-- add users --}}


<div class="col-md-4 position-relative mt-0">
    <label for="province">Province:</label>
    <select id="province" name="provinces_id" class="form-control">
        <option value="">Select Province</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}">{{ $province->provinces }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-4 position-relative mt-0">
    <label for="municipality">Municipality:</label>
    <select id="municipality" name="municipalities_id" class="form-control">
        <option value="">Select Municipality</option>
    </select>
</div>

<div class="col-md-4 position-relative mt-0">
    <label for="barangay">Barangay:</label>
    <select id="barangay" name="barangays_id" class="form-control">
        <option value="">Select Barangay</option>
    </select>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script>

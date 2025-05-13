@extends('layouts.index')

@section('content')

@if (session()->has('message'))
<div id="success-alert" class="alert alert-success text-center">
    {{ session('message') }}
</div>
@endif

@if (session()->has('error'))
<div id="error-alert" class="alert alert-danger">
    {{ session('error') }}
</div>
@endif


    <script>
        // Function to hide the alert after a specified number of milliseconds
        function hideAlert(alertId, delay) {
            setTimeout(function() {
                document.getElementById(alertId).style.display = 'none';
            }, delay);
        }

        // Automatically hide success alert after 3 seconds
        if (document.getElementById('success-alert')) {
            hideAlert('success-alert', 10000);
        }

        // Automatically hide error alert after 3 seconds
        if (document.getElementById('error-alert')) {
            hideAlert('error-alert', 10000);
        }
    </script>

    <div class="pagetitle">
        <h1>Farmers Data</h1>
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item active">Farmers Data</li> --}}
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="add-employee mb-3 mt-3">
                            <a href="{{ url('create-add') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> Add Farmer
                            </a>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-3" style="display: none;">
                                <input type="text" id="search" class="form-control" placeholder="Search">
                            </div>
                        </div> --}}

                        <div class="row d-flex justify-content-end mt-3">
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="barangayFilter">Filter by Barangay:</label>
                                    <select id="barangayFilter" class="form-control" onchange="updateTableForSelectedBarangay()">
                                        <option value="">All Barangays</option>
                                        <option value="Almeida">Almeida</option>
                                        <option value="Antonino">Antonino</option>
                                        <option value="Apatut">Apatut</option>
                                        <option value="Ar-arampang">Ar-arampang</option>
                                        <option value="Baracbac Este">Baracbac Este</option>
                                        <option value="Baracbac Oeste">Baracbac Oeste</option>
                                        <option value="Bet-ang">Bet-ang</option>
                                        <option value="Bulbulala">Bulbulala</option>
                                        <option value="Bungol">Bungol</option>
                                        <option value="Butubut Este">Butubut Este</option>
                                        <option value="Butubut Norte">Butubut Norte</option>
                                        <option value="Butubut Oeste">Butubut Oeste</option>
                                        <option value="Butubut Sur">Butubut Sur</option>
                                        <option value="Cabuaan">Cabuaan</option>
                                        <option value="Calliat">Calliat</option>
                                        <option value="Calungbuyan">Calungbuyan</option>
                                        <option value="Camiling">Camiling</option>
                                        <option value="Dr. Camilo Osias">Dr. Camilo Osias</option>
                                        <option value="Guinaburan">Guinaburan</option>
                                        <option value="Masupe">Masupe</option>
                                        <option value="Nagsabaran Norte">Nagsabaran Norte</option>
                                        <option value="Nagsabaran Sur">Nagsabaran Sur</option>
                                        <option value="Nalasin">Nalasin</option>
                                        <option value="Napaset">Napaset</option>
                                        <option value="Pa-o">Pa-o</option>
                                        <option value="Pagbennecan">Pagbennecan</option>
                                        <option value="Pagleddegan">Pagleddegan</option>
                                        <option value="Pantar Norte">Pantar Norte</option>
                                        <option value="Pantar Sur">Pantar Sur</option>
                                        <option value="Paraoir">Paraoir</option>
                                        <option value="Patpata">Patpata</option>
                                        <option value="Sablut">Sablut</option>
                                        <option value="San Pablo">San Pablo</option>
                                        <option value="Sinapangan Norte">Sinapangan Norte</option>
                                        <option value="Sinapangan Sur">Sinapangan Sur</option>
                                        <option value="Tallipugo">Tallipugo</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="commodityFilter">Filter by Commodities:</label>
                                    <select id="commodityFilter" class="form-control" onchange="updateTableFilters()">
                                        <option value="">All Commodities</option>
                                        <option value="Rice">Rice</option>
                                        <option value="Corn">Corn</option>
                                        <option value="Tobacco">Tobacco</option>
                                        <option value="Talong">Talong</option>
                                        <option value="Okra">Okra</option>
                                        <option value="Ampalaya">Ampalaya</option>
                                        <option value="Sitaw">Sitaw</option>
                                        <option value="Sili">Sili</option>
                                        <option value="Kalabasa">Kalabasa</option>
                                        <option value="Patola">Patola</option>
                                        <option value="Upo">Upo</option>
                                        <option value="Pechay">Pechay</option>
                                        <option value="Monggo">Monggo</option>
                                        <option value="Peanut">Peanut</option>
                                        <option value="Camote">Camote</option>
                                        <option value="Banana">Banana</option>
                                        <option value="Livestock">Livestock</option>
                                        <option value="Poultry">Poultry</option>
                                        <option value="Watermelon">Watermelon</option>
                                        <option value="Cassava">Cassava</option>
                                        <option value="Pipino">Pipino</option>
                                    </select>
                                </div>


                                <div class="col-md-3">
                                    <label for="statusFilter">Filter by Status:</label>
                                    <select id="statusFilter" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="beneficiaryFilter">Filter by 4ps Beneficiary:</label>
                                    <select id="beneficiaryFilter" class="form-control">
                                        <option value="">All Beneficiaries</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" /> --}}

                        <script>
                            $(document).ready(function () {
                                var table = $('#myTable').DataTable({
                                    searching: true, // Enable DataTables search bar
                                    // other DataTable options...
                                });

                                // Event handler for changes in the global search input
                                $('#globalSearch').on('keyup', function () {
                                    table.search(this.value).draw(); // Apply global search
                                });

                                // Event handlers for filter changes
                                $('#barangayFilter, #commodityFilter, #statusFilter, #beneficiaryFilter').change(function () {
                                    updateTableFilters();
                                });

                                // Listen for changes in the global search input
                                $('#myTable_filter input').on('keyup', function () {
                                    updateTableFilters();
                                });

                                function updateTableFilters() {
    var barangayFilter = $('#barangayFilter').val();
    var commodityFilter = $('#commodityFilter').val();
    var statusFilter = $('#statusFilter').val();
    var beneficiaryFilter = $('#beneficiaryFilter').val();
    var globalSearchTerm = $('#globalSearch').val();

    // Use DataTables API to filter the table
    table
        .columns(2).search(barangayFilter)
        .columns(3).search(commodityFilter)
        .columns(5).search(statusFilter === '' ? '' : '^' + statusFilter + '$', true, false)
        .columns(4).search(beneficiaryFilter)
        .draw();

    // Show or hide commodities based on the filter
    if (commodityFilter === '' || commodityFilter === 'All Commodities') {
        $('.commodities-td span').show();
    } else {
        var selectedCommodities = commodityFilter.split(',');
        $('.commodities-td span').hide().filter(function () {
            return selectedCommodities.indexOf($(this).text()) !== -1;
        }).show();
    }
}


                            });
                        </script>



                        <div class="table-responsive mt-3">
                            <table id="myTable" class="table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Barangay</th>
                                        <th scope="col">Commodities</th>
                                        <th scope="col">4ps Beneficiary</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($farmers as $farmer)
                                        <tr data-barangay="{{ $farmer->barangay->id }}"
                                            data-commodities="{{ implode(',', $farmer->crops->pluck('commodities_id')->toArray()) }}"
                                            data-status="{{ $farmer->status }}">
                                            <td>{{ $farmer->farmersNumbers?->first()?->farmersnumber ?? 'No Data' }}</td>
                                            <td>{{ $farmer->fname }} {{ $farmer->sname }}</td>
                                            <td>{{ $farmer->barangay?->barangays ?? 'No Data' }}</td>
                                            <td class="commodities-td">
                                                @php
                                                    $farmerCommodities = $farmer->crops->pluck('commodities_id')->toArray();
                                                    $selectedCommodities = $selectedCommodities ?? [];

                                                    if (!empty($selectedCommodities) && $selectedCommodities[0] !== '') {
                                                        // Only display selected commodities
                                                        $selectedFarmerCommodities = array_intersect($farmerCommodities, $selectedCommodities);
                                                        $displayedCommodities = $commodities->whereIn('id', $selectedFarmerCommodities)->pluck('commodities')->toArray();
                                                        foreach ($displayedCommodities as $commodity) {
                                                            echo '<span class="commodity">' . $commodity . '</span><br>';
                                                        }
                                                    } elseif (!empty($farmerCommodities)) {
                                                        // Display all commodities
                                                        $allCommodities = $commodities->whereIn('id', $farmerCommodities)->pluck('commodities')->toArray();
                                                        foreach ($allCommodities as $commodity) {
                                                            echo '<span class="commodity">' . $commodity . '</span><br>';
                                                        }
                                                    } else {
                                                        echo 'No Data';
                                                    }

                                                    // // Display Others information
                                                    // $others = $farmer->others;
                                                    // foreach ($others as $other) {
                                                    //     echo '<span class="commodity">' . $other->others . '</span><br>';
                                                    // }
                                                @endphp
                                            </td>

                                            <td>{{ $farmer->benefits }}</td>
                                            <td>
                                                @if ($farmer->status === 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                           <td class="text-center">
    <div class="btn-group" role="group">
        <!-- PDF Icon -->
        <a href="{{ route('generate.pdf', ['id' => $farmer->id]) }}" class="btn btn-sm btn-info" style="margin-right: 10px;">
            <i class="bi bi-file-earmark-pdf"></i> <!-- Bootstrap Icon for PDF -->
        </a>

        <!-- View Icon -->
        <a href="{{ route('farmers.showed', ['id' => $farmer->id]) }}" class="btn btn-sm btn-info" style="margin-right: 10px;">
            <i class="bi bi-eye"></i> <!-- Bootstrap Icon for View -->
        </a>

        <!-- Edit Icon -->
        <a href="{{ route('farmers.edit', ['id' => $farmer->id]) }}" class="btn btn-sm btn-primary" style="margin-right: 10px;">
            <i class="bi bi-pencil"></i> <!-- Bootstrap Icon for Edit -->
        </a>

        <!-- ID Card Icon -->
        <a href="{{ route('farmers.generate', ['id' => $farmer->id]) }}" class="btn btn-sm btn-secondary">
            <i class="bi bi-person-vcard"></i> <!-- Bootstrap Icon for ID Card -->
        </a>

        <!-- Benefits Icon -->
        <a href="{{ route('farmers.benefits', ['id' => $farmer->id]) }}" class="btn btn-sm btn-secondary">
            <i class="bi bi-gift"></i> <!-- Bootstrap Icon for Benefits -->
        </a>
    </div>
</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <style>
        .status-circle {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .active {
            background-color: green;
        }

        .inactive {
            background-color: red;
        }

        .dataTables_length {
            margin-bottom: 20px;
            /* Adjust the margin as needed */
        }

         /* Style the table */
    #myTable {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    #myTable th,
    #myTable td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ccc;
    }

    #myTable th {
        background-color: #f2f2f2;
    }

    /* Style the table header */
    #myTable thead {
        font-weight: bold;
    }

    /* Style the "Add Farmer" button */
    .add-employee a.btn {
        background-color: #007bff;
        color: #fff;
    }

    .add-employee a.btn:hover {
        background-color: #0056b3;
    }

    /* Style the action buttons */
    .btn-group .btn {
        padding: 5px 10px;
        margin-right: 5px;
        border: none;
    }

    /* Style the status badges */
    .badge.bg-success {
        background-color: #28a745;
    }

    .badge.bg-danger {
        background-color: #dc3545;
    }
    </style>



@endsection


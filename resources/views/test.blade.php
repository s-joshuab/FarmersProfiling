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

    <div class="pagetitle">
        <h1>Reports</h1>
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
                        <div class="row">
                            <div class="col-md-3" style="display: none;">
                                <input type="text" id="search" class="form-control" placeholder="Search">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-end mt-3">
                            <div class="col-md-2">
                                <div id="commoditiesFilterDisplay" style="display: none;"></div>
                            </div>
                            <div class="col-md-2">
                                <select id="barangayFilter" class="form-select" aria-label="Barangay Filter">
                                    <option value="">All Barangays</option>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->barangays }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="dropdown" style="margin-left: 10px;">
                                    <button class="btn btn-light dropdown-toggle" type="button" id="commoditiesDropdown" data-bs-toggle="dropdown" style="background-color: white; border: 1px solid #ccc;">
                                        Commodities
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="commoditiesDropdown">
                                        <li>
                                            <input class="form-check-input" type="checkbox" value="all" id="commodityCheckboxAll">
                                            <label class="form-check-label" for="commodityCheckboxAll">All Commodities</label>
                                        </li>
                                        @foreach ($commodities as $commodity)
                                            <li>
                                                <input class="form-check-input commodity-checkbox" type="checkbox" value="{{ $commodity->id }}" id="commodityCheckbox{{ $commodity->id }}">
                                                <label class="form-check-label" for="commodityCheckbox{{ $commodity->id }}">{{ $commodity->commodities }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <select name="statusFilter" id="statusFilter" class="form-select" aria-label="Status Filter">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Barangay</th>
                                        <th scope="col">Commodities</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Farm Size</th>
                                        <th scope="col">Farm Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($farmers as $farmer)
                                        <tr data-barangay="{{ $farmer->barangay->id }}"
                                            data-commodities="{{ implode(',', $farmer->crops->pluck('commodities_id')->toArray()) }}"
                                            data-status="{{ $farmer->status }}">
                                            <td>{{ $farmer->farmersNumbers->first()->farmersnumber ?? 'No Data' }}</td>
                                            <td>{{ $farmer->fname }} {{ $farmer->sname }}</td>
                                            <td>{{ $farmer->barangay->barangays ?? 'No Data' }}</td>
                                            <td>
                                                @php
                                                    $selectedCommodityIds = $selectedCommodityIds ? $selectedCommodityIds : ['all'];
                                                    $selectedCommodities = $commodities->whereIn('id', $selectedCommodityIds);
                                                    if ($selectedCommodities->isNotEmpty()) {
                                                        echo $selectedCommodities->pluck('commodities')->implode('<br>');
                                                    } else {
                                                        echo 'No Data';
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @if ($farmer->status === 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($farmer->crops)
                                                    @forelse ($farmer->crops as $crops)
                                                        @if (in_array($crops->commodities_id, $selectedCommodityIds) || in_array('all', $selectedCommodityIds))
                                                            {{$crops->farm_size}} <br>
                                                        @endif
                                                    @empty
                                                        No Farm Size
                                                    @endforelse
                                                @endif
                                            </td>
                                            <td>
                                                @if($farmer->crops)
                                                    @forelse ($farmer->crops as $crops)
                                                        @if (in_array($crops->commodities_id, $selectedCommodityIds) || in_array('all', $selectedCommodityIds))
                                                            {{$crops->farm_location}} <br>
                                                        @endif
                                                    @empty
                                                        No Farm Location
                                                    @endforelse
                                                @endif
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
    </style>

    <script>
// JavaScript variable containing the mapping of commodity IDs to names
var commodityMap = {
    @foreach ($commodities as $commodity)
        {{ $commodity->id }}: '{{ $commodity->commodities }}',
    @endforeach
};

// Keep track of the selected commodity IDs
var selectedCommodityIds = [];

// Function to hide the farm_size and farm_location columns
function hideFarmColumns() {
    $('#myTable tbody tr').each(function() {
        var tr = $(this);
        var trCommodities = tr.data('commodities').split(',').map(Number);

        if (selectedCommodityIds.length > 0 && !selectedCommodityIds.includes('all')) {
            // Check if the row's commodities match the selected commodity
            var hasSelectedCommodity = trCommodities.some(commodityId => selectedCommodityIds.includes(commodityId.toString()));

            if (hasSelectedCommodity) {
                // Display the farm_size and farm_location columns for selected commodities
                tr.find('td:eq(5), td:eq(6)').show();
            } else {
                // Hide the farm_size and farm_location columns for non-selected commodities
                tr.find('td:eq(5), td:eq(6)').hide();
            }
        } else {
            // If no specific commodities are selected, show all farm_size and farm_location columns
            tr.find('td:eq(5), td:eq(6)').show();
        }
    });
}

// Function to update the displayed commodities in the filter
function updateCommoditiesFilterDisplay() {
    var selectedCommodities = [];

    selectedCommodityIds.forEach(function(commodityId) {
        selectedCommodities.push(commodityMap[commodityId]);
    });

    var commoditiesFilterDisplay = selectedCommodities.join(', ');
    if (commoditiesFilterDisplay === '') {
        commoditiesFilterDisplay = 'All Commodities';
    }

    $('#commoditiesFilterDisplay').text(commoditiesFilterDisplay);
}

$(document).ready(function() {
    // Initialize DataTable
    $('#myTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "pagingType": "full_numbers",
    });

    // Event listener for changing the number of entries per page
    $('#showEntries').on('change', function() {
        var entriesPerPage = parseInt($(this).val());
        $('#myTable').DataTable().page.len(entriesPerPage).draw();
    });

    // Event listener for checkboxes
    $('.commodity-checkbox').on('change', function() {
        updateSelectedCommodities();
        hideFarmColumns(); // Update the visibility of farm_size and farm_location
        filterTable();
    });

    // Event listener for the "All Commodities" checkbox
    $('#commodityCheckboxAll').on('change', function() {
        // If "All Commodities" is checked, uncheck all other checkboxes
        if ($(this).is(':checked')) {
            $('.commodity-checkbox').prop('checked', false);
        }
        updateSelectedCommodities();
        hideFarmColumns(); // Update the visibility of farm_size and farm_location
        filterTable();
    });

    // Function to update the selectedCommodityIds array based on the checkboxes
    function updateSelectedCommodities() {
        selectedCommodityIds = [];

        if ($('#commodityCheckboxAll').is(':checked')) {
            selectedCommodityIds.push('all');
        } else {
            $('.commodity-checkbox:checked').each(function() {
                selectedCommodityIds.push($(this).val());
            });
        }

        updateCommoditiesFilterDisplay();
    }

    // Function to filter the table based on selected filters
    function filterTable() {
        var selectedBarangayIds = $('#barangayFilter').val();
        var selectedStatus = $('#statusFilter').val();
        var searchText = $('#search').val().toLowerCase();

        $('#myTable tbody tr').each(function() {
            var tr = $(this);
            var trCommodities = tr.data('commodities').split(',').map(Number);
            var trStatus = tr.data('status');
            var trText = tr.text().toLowerCase();

            var showRow = true;

            if (selectedBarangayIds.length > 0 && selectedBarangayIds[0] !== '') {
                // Check if the row's barangay is in the selected barangays
                if (!selectedBarangayIds.includes(trBarangayId.toString())) {
                    showRow = false;
                }
            }

            if (selectedStatus !== '' && selectedStatus != trStatus) {
                showRow = false;
            }

            if (searchText !== '' && !trText.includes(searchText)) {
                showRow = false;
            }

            if (selectedCommodityIds.length > 0 && !selectedCommodityIds.includes('all')) {
                // Check if the row's commodities match the selected commodity
                var hasSelectedCommodity = trCommodities.some(commodityId => selectedCommodityIds.includes(commodityId.toString()));

                if (hasSelectedCommodity) {
                    // Update the displayed commodities in the table cell
                    var displayedCommodities = trCommodities.map(function(commodityId) {
                        if (selectedCommodityIds.includes(commodityId.toString())) {
                            return commodityMap[commodityId];
                        }
                    }).filter(Boolean).join('<br>');

                    tr.find('td:eq(3)').html(displayedCommodities);
                } else {
                    // If the farmer doesn't have the selected commodities, hide the row
                    tr.find('td:eq(5), td:eq(6)').hide(); // Hide farm_size and farm_location columns
                    tr.find('td:eq(3)').html(''); // Clear the commodities cell
                    showRow = false;
                }
            } else {
                // If no specific commodities are selected, show all the commodities for the farmer
                var allCommodities = trCommodities.map(commodityId => commodityMap[commodityId]).join('<br>');
                tr.find('td:eq(3)').html(allCommodities);
            }

            if (showRow) {
                tr.show();
            } else {
                tr.hide();
            }
        });
    }

    // Add the event listener for changes in the filters
    $('#barangayFilter, #statusFilter, #search').on('change keyup', function() {
        filterTable();
    });

    // Initial filter when the page loads
    filterTable();
    updateCommoditiesFilterDisplay(); // Initial update of the displayed commodities in the filter
});
</script>

@endsection

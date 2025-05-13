@extends('layouts.index')
@section('content')
    <title>Dashboard</title>

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            {{-- <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol> --}}
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Farmers -->
                    <div class="col-md-4">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="#" id="filter-dropdown-toggle"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end" id="filter-dropdown">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter by Barangay</h6>
                                    </li>
                                    <li>
                                        <div class="dropdown-item">
                                            <select class="form-select" id="barangay-select">
                                                <option value="">All Barangay</option>
                                                @foreach ($barangays as $barangay)
                                                    <option value="{{ $barangay->id }}">{{ $barangay->barangays }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Total Farmers</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="farmer-count">{{ $farmerCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const filterDropdownToggle = document.getElementById('filter-dropdown-toggle');
                            const filterDropdown = document.getElementById('filter-dropdown');
                            const farmerCountElement = document.getElementById('farmer-count');
                            const barangaySelect = document.getElementById('barangay-select');

                            filterDropdownToggle.addEventListener('click', (e) => {
                                e.preventDefault();
                                filterDropdown.classList.toggle('show');
                            });

                            // Event listener for selecting a barangay
                            barangaySelect.addEventListener('change', function () {
                                const selectedBarangayId = this.value;

                                // Check if "All Barangay" is selected
                                if (selectedBarangayId === '') {
                                    // Make an AJAX request to fetch the count of all farmers
                                    fetch(`/get-all-farmers-count`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Update the farmer count
                                            farmerCountElement.textContent = data.farmerCount;
                                        });
                                } else {
                                    // Make an AJAX request to fetch the count of farmers for the selected barangay
                                    fetch(`/get-farmer-count/${selectedBarangayId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Update the farmer count
                                            farmerCountElement.textContent = data.farmerCount;
                                        });
                                }
                            });
                        });
                    </script>

                    <!-- 4ps -->
                    <div class="col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">4p's Beneficiaries</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $benefits }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active -->
                    <div class="col-md-4">
                        <div class="card info-card revenue-card">
                            {{-- <div class="filter">
                                <a class="icon" href="#" id="status-filter-dropdown-toggle"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end" id="status-filter-dropdown">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter by Status</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-option" data-filter="active" href="#">Active</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="inactive" href="#">Inactive</a></li>
                                </ul>
                            </div> --}}
                            <div class="card-body">
                                <h5 class="card-title">Status</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="active-status-count">{{ $activeStatusCount }} Active</h6>
                                        <h6 id="inactive-status-count" class="mt-1" style="font-size: 16px">{{ $inactiveStatusCount }} InActive</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const statusFilterDropdownToggle = document.getElementById('status-filter-dropdown-toggle');
                            const statusFilterDropdown = document.getElementById('status-filter-dropdown');
                            const filterTextElement = document.getElementById('filter-text'); // Element to display the selected filter

                            statusFilterDropdownToggle.addEventListener('click', (e) => {
                                e.preventDefault();
                                statusFilterDropdown.classList.toggle('show');
                            });

                            // Event listener for selecting a filter option
                            const filterOptions = document.querySelectorAll('.filter-option');
                            filterOptions.forEach(option => {
                                option.addEventListener('click', function () {
                                    const selectedFilter = this.getAttribute('data-filter');

                                    // Make an AJAX request to fetch the counts based on the selected filter
                                    fetch(`/get-status-count/${selectedFilter}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Update the counts based on the response data
                                            document.getElementById('active-status-count').textContent = data.activeStatusCount;
                                            document.getElementById('inactive-status-count').textContent = data.inactiveStatusCount;

                                            // Update the selected filter text in the card
                                            filterTextElement.textContent = selectedFilter;

                                            // Close the dropdown
                                            statusFilterDropdown.classList.remove('show');
                                        });
                                });
                            });
                        });
                    </script>


                    <!-- Users -->
                    {{-- <div class="col-md-3">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $user }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Top 5 Commodities</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($maxCommodities as $commodity)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $commodity['name'] }}
                                            <span class="badge bg-primary rounded-pill">{{ $commodity['count'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('commodities') }}" class="btn btn-primary mt-3">See More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Commodities</h5>
                                <!-- Bar Chart -->
                                <canvas id="barChart" style="max-height: 400px;"></canvas>
                                {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new Chart(document.querySelector('#barChart'), {
                                            type: 'bar',
                                            data: {
                                                labels: {!! json_encode($commodityNames) !!},
                                                datasets: [{
                                                    label: 'Counts',
                                                    data: {!! json_encode($commodityCounts) !!},
                                                    backgroundColor: generateRandomColors({{ count($commodityNames) }}), // Generate random colors
                                                    borderColor: 'rgba(75, 192, 192, 1)',
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        ticks: {
                                                            callback: function (value) {
                                                                if (value % 1 === 0) { // Display whole numbers only
                                                                    return value;
                                                                }
                                                            }
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: false, // Hide legend
                                                    },
                                                },
                                                responsive: true,
                                                maintainAspectRatio: false,
                                            }
                                        });

                                        // Function to generate random colors
                                        function generateRandomColors(count) {
                                            const colors = [];
                                            for (let i = 0; i < count; i++) {
                                                const color = getRandomColor();
                                                colors.push(color);
                                            }
                                            return colors;
                                        }

                                        // Function to generate a random color
                                        function getRandomColor() {
                                            const letters = '0123456789ABCDEF';
                                            let color = '#';
                                            for (let i = 0; i < 6; i++) {
                                                color += letters[Math.floor(Math.random() * 16)];
                                            }
                                            return color;
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-4">
                        <div class="card recent-sales overflow-auto" style="margin-top: -250px;">
                            <div class="card-body">
                                <h5 class="card-title">Most Planted Commodities by Barangay</h5>

                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Barangay</th>
                                            <th>Most Commodities Planted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mostPlantedByBarangay as $item)
                                            <tr>
                                                <td>{{ $item['barangay'] ?? 'No Data' }}</td>
                                                <td>{{ $item['most_commodity'] ?? 'No Data' }} </td>




                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-3">
                        <!-- Budget Report -->
                        <div class="card">
                            {{-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> --}}

                            <div class="card-body">
                                <h5 class="card-title">Total Male and Female Farmers</h5>

                                <!-- Pie Chart -->
                                <canvas id="pieChart" style="max-height: 400px; max-width: 400px;"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new Chart(document.querySelector('#pieChart'), {
                                            type: 'pie',
                                            data: {
                                                labels: [
                                                    'Male',
                                                    'Female'
                                                ],
                                                datasets: [{
                                                    data: [{!! $maleCount !!}, {!! $femaleCount !!}],
                                                    backgroundColor: [
                                                        'rgb(255, 99, 132)',
                                                        'rgb(255, 205, 86)'
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div><!-- End Pie Chart -->

                    </div>



            </div>

        </div>
        </div>
    </section>
@endsection

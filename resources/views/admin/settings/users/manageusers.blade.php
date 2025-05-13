@extends('layouts.index')
@section('content')
    <title>Manage Users</title>

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
            hideAlert('success-alert', 3000);
        }

        // Automatically hide error alert after 3 seconds
        if (document.getElementById('error-alert')) {
            hideAlert('error-alert', 3000);
        }
    </script>

    <div class="pagetitle">
        <h1>Manage Users</h1>
        <nav>
            <ol class="breadcrumb"></ol>
        </nav>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="add-employee mb-3 mt-3">
                            <a href="{{ url('users-add') }}" class="btn btn-primary">
                                <i class="bi bi-plus"></i> Add Users
                            </a>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-3">
                                <select id="showEntries" class="form-select" aria-label="Show Entries">
                                    <option value="10">Show 10 Entries</option>
                                    <option value="25">Show 25 Entries</option>
                                    <option value="50">Show 50 Entries</option>
                                    <option value="100">Show 100 Entries</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="search" class="form-control" placeholder="Search">
                            </div>
                        </div> --}}

                        <div class="table-responsive mt-3">
                            <table id="userTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        {{-- <th class="text-center">Barangay</th> --}}
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">UserType</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                @if ($user->image)
                                                    <img src="data:image/jpeg;base64,{{ $user->image }}"
                                                        class="avatar rounded-circle" alt="Avatar" style="width: 50px; height: 50px;">
                                                @else
                                                    <img src="{{ asset('assets/img/default.jpg') }}"
                                                        class="avatar rounded-circle" alt="Default Avatar" style="width: 50px; height: 50px;">
                                                @endif
                                                {{ $user->name }}
                                            </td>
                                            {{-- <td class="text-center">{{ $user->barangay ? $user->barangay->barangays : 'No Data' }}</td> --}}
                                            <td class="text-center">{{ $user->phone_number }}</td>
                                            <td class="text-center">
                                                @if ($user->status === 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($user->user_type == 'Secretary')
                                                    <span>Brgy. </span>
                                                @endif
                                                {{ $user->user_type }}
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ url('user-view/' . $user->id) }}"
                                                        class="btn btn-sm btn-info view-btn m-1">
                                                        View
                                                    </a>
                                                    <a href="{{ url('user-edit/' . $user->id) }}"
                                                        class="btn btn-sm btn-primary view-btn m-1">
                                                        Update
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No Data Available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
    /* Custom styles for the table */
    .table-bordered {
        border: 1px solid #dee2e6; /* Gray border for the entire table */
        border-collapse: collapse; /* Remove cell spacing */
        width: 100%;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6; /* Gray border for table cells */
        padding: 10px;

    }

    .table-bordered th {
        background-color: #f8f9fa; /* Light blue-gray background for table headers */
    }

    .table-bordered tbody tr:nth-of-type(odd) {
        background-color: #f7f7f7; /* Light gray background for odd rows */
    }

    .table-bordered tbody tr:hover {
        background-color: #d1e7f3; /* Light blue background on hover */
    }

    .table-bordered td {
        background-color: #fff; /* White background for table cells */
        color: #333; /* Dark text color for cells */
    }
</style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userTable = $('#userTable').DataTable({
                "order": [],
                "lengthMenu": [10, 25, 50, 100],
                "pageLength": 10,
                "bLengthChange": true,
                "searching": true,
                "autoWidth": true,
                "responsive": true
            });

            $('#showEntries').change(function() {
                userTable.page.len($(this).val()).draw();
            });

            $('#search').on('keyup', function() {
                userTable.search(this.value).draw();
            });
        });
    </script>
@endsection

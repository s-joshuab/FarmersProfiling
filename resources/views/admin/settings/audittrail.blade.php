@extends('layouts.index')
@section('content')

    <style>
        /* Custom styles for the table */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f7f7f7;
            /* Light gray background for odd rows */
        }

        .table-bordered th,
        .table-bordered td {
            border-color: #dee2e6;
            /* Gray border color */
        }

        .table-bordered th {
            background-color: #f8f9fa;
            /* Light blue-gray background for table headers */
        }

        /* Custom styles for the table */
        .table-bordered {
            border: 1px solid #dee2e6;
            /* Gray border for the entire table */
            border-collapse: collapse;
            /* Remove cell spacing */
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            /* Gray border for table cells */
            padding: 10px;

        }

        .table-bordered th {
            background-color: #f8f9fa;
            /* Light blue-gray background for table headers */
        }

        .table-bordered tbody tr:nth-of-type(odd) {
            background-color: #f7f7f7;
            /* Light gray background for odd rows */
        }

        .table-bordered tbody tr:hover {
            background-color: #d1e7f3;
            /* Light blue background on hover */
        }

        .table-bordered td {
            background-color: #fff;
            /* White background for table cells */
            color: #333;
            /* Dark text color for cells */
        }
    </style>

<div class="container-fluid">
    <h1 class="my-4">Transaction Logs</h1>

    <div class="card">
        <div class="card-body">
            {{-- <form action="{{ route('audit') }}" method="GET" class="container">
                <label for="date_filter">Filter by Date:</label>
                <select name="date_filter" id="date_filter">
                    <option value="all">All</option>
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                </select>
            </form> --}}
            <div class="table-responsive">
                <table class="table datatable table-bordered table-striped" id="auditTrailTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date and Time</th>
                            <th>Name</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->created_at }}</td>
                                <td>{{ $activity->causer ? $activity->causer->name : 'No Data' }}</td>
                                <td>
                                    {{ $activity->causer && $activity->causer->user_type ? $activity->causer->user_type : 'No Data' }}
                                </td>
                                <td>{{ ucwords($activity->description) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Display a message when no records are found -->
            @if(count($activities) === 0)
                <p class="text-center mt-3">No records found for the selected date range.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function filterTable(selectedValue) {
        var table = document.getElementById('auditTrailTable').getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');
        var now = new Date();

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var dateCell = row.getElementsByTagName('td')[0];
            var date = new Date(dateCell.textContent);

            if (selectedValue === 'all') {
                row.style.display = '';
            } else {
                var showRow = false;

                if (selectedValue === 'today' && isSameDate(now, date)) {
                    showRow = true;
                } else if (selectedValue === 'this_week' && isThisWeek(now, date)) {
                    showRow = true;
                } else if (selectedValue === 'this_month' && isThisMonth(now, date)) {
                    showRow = true;
                }

                row.style.display = showRow ? '' : 'none';
            }
        }
    }

    function isSameDate(date1, date2) {
        return date1.toDateString() === date2.toDateString();
    }

    function isThisWeek(date1, date2) {
        var oneDay = 24 * 60 * 60 * 1000;
        var diffDays = Math.round(Math.abs((date1 - date2) / oneDay));
        return diffDays <= date1.getDay();
    }

    function isThisMonth(date1, date2) {
        return date1.getMonth() === date2.getMonth() && date1.getFullYear() === date2.getFullYear();
    }

    filterTable(document.getElementById('date_filter').value);

    document.getElementById('date_filter').addEventListener('change', function() {
        var selectedValue = this.value;
        filterTable(selectedValue);
    });
</script>
@endsection

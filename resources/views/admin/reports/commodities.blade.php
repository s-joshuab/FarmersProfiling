@extends('layouts.index')

@section('content')
    <section>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                         <h3>Top Commodities in Each Barangays</h3>
                        <div class="table-responsive mt-3">
                            <table id="myTable" class="datatable table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Barangay</th>
                                        <th scope="col">Most Planted Commodity</th>
                                        <th scope="col">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $row)
                                        <tr>
                                            <td>{{ $row->barangay }}</td>
                                            <td>{{ $row->commodity }}</td>
                                            <td>{{ $row->count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
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

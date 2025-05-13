@extends('layouts.index')

@section('content')
    <section>
        <div class="pagetitle">
            <h1>Reports</h1>
            <nav>
                <ol class="breadcrumb">
                    {{-- <li class="breadcrumb-item active">Farmers Data</li> --}}
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-body">
                <div class="col-lg-12">
                    <livewire:crops-table />
                </div>
                </div>
            </div>
        </div>
    </section>
@endsection







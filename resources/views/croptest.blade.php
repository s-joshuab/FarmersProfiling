@extends('layouts.index')

@section('content')
    <section>
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




















////



@extends('layouts.index')
@section('content')
<div class="col-md-12">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row">
        <form action="{{ url('test/form/add') }}" method="POST">
            @csrf
            @method('post')

            <div class="container">
                <h1>Select Commodities</h1>

                @foreach($commodities as $id => $commodity)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $id }}" name="selected_commodities[]">
                        <label class="form-check-label" for="commodity{{ $id }}">
                            {{ $commodity }}
                        </label>
                    </div>
                    <div class="commodity-inputs">
                        <div class="form-group">
                            <label for="farmSize{{ $id }}">Farm Size</label>
                            <input type="text" class="form-control" id="farmSize{{ $id }}" name="farm_size[{{ $id }}]">
                        </div>
                        <div class="form-group">
                            <label for="location{{ $id }}">Location</label>
                            <input type="text" class="form-control" id="location{{ $id }}" name="farm_location[{{ $id }}]">
                        </div>
                    </div>
                @endforeach
                <div class="my-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>


@endsection

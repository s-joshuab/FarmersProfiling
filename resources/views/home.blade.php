@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <div class="card shadow-md p-5">

    <div class="row justify-content-center">
        <form action="{{ url('home/add') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Email</label>
              <input type="text" class="form-control" id="exampleInputPassword1" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="password">
              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>
</div>

@endsection

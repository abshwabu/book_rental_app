@extends('layouts.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Total Users: {{ $userCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Total Books: {{ $bookCount }}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection

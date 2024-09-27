@extends('layouts.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Total Users: {{ $totalUsers }}</h5>
                    <h5>Total Books: {{ $totalBooks }}</h5>
                </div>
            </div>
        </div>

        <!-- Top Rented Books -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top 5 Rented Books</div>
                <div class="card-body">
                    <ul>
                        @foreach ($topBooks as $book)
                            <li>{{ $book->title }} - Rented {{ $book->rentals_count }} times</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Most Active Renters -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top 5 Active Renters</div>
                <div class="card-body">
                    <ul>
                        @foreach ($activeRenters as $renter)
                            <li>{{ $renter->name }} - {{ $renter->rentals_count }} rentals</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

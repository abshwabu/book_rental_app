@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }}</h2>

    <div class="card mb-3">
        <div class="card-body">
            <h4>Total Earnings: ${{ $totalEarnings }}</h4>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h4>Total Rentals: {{ $totalRentals }}</h4>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h4>Your Books</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Rental Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->category }}</td>
                        <td>${{ $book->rental_price }}</td>
                        <td>{{ $book->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

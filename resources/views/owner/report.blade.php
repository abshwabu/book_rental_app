@extends('layouts.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Book Rental Report</h1>

    @if($rentals->isEmpty())
        <p>No rentals available for your books.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Renter Name</th>
                    <th>Rented On</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->book->title }}</td>
                        <td>{{ $rental->renter->name }}</td>
                        <td>{{ $rental->rented_at }}</td>
                        <td>{{ $rental->due_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

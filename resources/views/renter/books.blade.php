@extends('layouts.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Renter Dashboard</h1>

    <h3>Books You've Rented</h3>

    @if($rentals->isEmpty())
        <p>You haven't rented any books yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Rental Price</th>
                    <th>Rented On</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->book->title }}</td>
                        <td>{{ $rental->book->author }}</td>
                        <td>{{ $rental->book->category }}</td>
                        <td>{{ $rental->book->rental_price }}</td>
                        <td>{{ $rental->rented_at }}</td>
                        <td>{{ $rental->due_date }}</td>
                        <td>
                            <form action="{{ route('rentals.return', $rental->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-success">Return</button>
                            </form>
                            <form action="{{ route('rentals.extend', $rental->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">Extend</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

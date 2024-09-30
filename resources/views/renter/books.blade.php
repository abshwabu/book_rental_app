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
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Rented On</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
                <tr>
                    <td>
                        @if($rental->book->cover_image)
                            <img src="{{asset('storage/' . $rental->book->cover_image)}}" alt="" width="60px" height="90px">
                        @else
                            No image
                        @endif
                    </td>
                    <td>{{ $rental->book->title }}</td>
                    <td>{{ $rental->book->author }}</td>
                    <td>{{ $rental->rented_at }}</td>
                    <td>{{ $rental->due_date }}</td>
                    <td>
                        @if($rental->status === 'rented')
                            <form action="{{ route('rentals.return', $rental->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Return</button>
                            </form>
                        @else
                            <span class="badge bg-primary">Returned</span>
                        @endif
                    </td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
    
    @endif
@endsection

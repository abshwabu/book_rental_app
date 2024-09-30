@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Manage Books</h2>

    @if($books->isEmpty())
        <p>No books found.</p>
    @else
        <table class="table table-hover">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Rental Price</th>
                <th>Owner</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category }}</td>
                    <td>{{ $book->quantity }}</td>
                    <td>{{ $book->rental_price }}</td>
                    <td>{{ $book->owner->name }}</td>
                    <td>{{ ucfirst($book->status) }}</td>
                    <td>
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="GET">
                            <button type="submit" class="btn btn-danger"> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        
    @endif
</div>
@endsection

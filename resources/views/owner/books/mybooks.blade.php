@extends('layouts.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">My Books</h1>

    @if($books->isEmpty())
        <p>You have not added any books yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Rental Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->category }}</td>
                        <td>{{ $book->quantity }}</td>
                        <td>{{ $book->rental_price }}</td>
                        <td>{{ ucfirst($book->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

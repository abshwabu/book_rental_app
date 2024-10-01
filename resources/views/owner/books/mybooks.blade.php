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
                    <th>Action</th>
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
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('owner.books.edit', $book->id) }}" method="get" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                </form>
                                <!-- Delete Button -->
                                <form action="{{ route('owner.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Manage Books</h2>

    @if($books->isEmpty())
        <p>No books found.</p>
    @else
        <ul>
            @foreach ($books as $book)
                <li>
                    <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                    Category: {{ $book->category }}<br>
                    Status: {{ ucfirst($book->status) }}<br>
                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</div>
@endsection

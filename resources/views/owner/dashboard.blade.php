@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>My Books</h2>
        <a href="{{ route('owner.books.create') }}">Add New Book</a>
        <form action="{{ route('owner.dashboard') }}" method="GET">
            <input type="text" name="search" placeholder="Search by title or category" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>        
        @if($books->isEmpty())
            <p>You haven't uploaded any books yet.</p>
        @else
            <ul>
                @foreach ($books as $book)
                    
                    <a href="{{ route('owner.books.edit', $book->id) }}"><li>{{ $book->title }} by {{ $book->author }}</li></a>
                    <form action="{{ route('owner.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>                    
                @endforeach
            </ul>
        @endif
    </div>
@endsection

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>My Books</h2>
        <a href="{{ route('owner.books.create') }}">Add New Book</a>

        @if($books->isEmpty())
            <p>You haven't uploaded any books yet.</p>
        @else
            <ul>
                @foreach ($books as $book)
                    <li>{{ $book->title }} by {{ $book->author }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

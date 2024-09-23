@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Available Books for Rent</h2>

        @if($books->isEmpty())
            <p>No books available for rent at the moment.</p>
        @else
            <ul>
                @foreach ($books as $book)
                    <li>{{ $book->title }} by {{ $book->author }} - {{ $book->rental_price }} Birr</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

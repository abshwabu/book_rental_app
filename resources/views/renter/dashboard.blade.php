@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Available Books for Rent</h2>

    @if($books->isEmpty())
        <p>No books available for rent at the moment.</p>
    @else
        <ul>
            @foreach ($books as $book)
                <li>
                    <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                    Category: {{ $book->category }}<br>
                    Price: {{ $book->rental_price }} Birr<br>
                    Quantity: {{ $book->quantity }}<br>
                    Status: {{ ucfirst($book->status) }}<br>
                </li>
                @if($book->quantity > 0)
                    <form action="{{ route('books.rent', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit">Rent this book</button>
                    </form>
                @else
                    <p>Currently unavailable</p>
                @endif

                <hr>
            @endforeach
        </ul>
    @endif
</div>
@endsection

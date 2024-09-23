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
                <hr>
            @endforeach
        </ul>
    @endif
</div>
@endsection

@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Available Books for Rent</h2>

    @if($books->isEmpty())
        <p>No books available for rent at the moment.</p>
    @else
        <ul>
            @foreach ($books as $book)
                
                @if($book->quantity > 0)
                    <li>
                        @if ($book->cover_image)
                            <img src="{{asset('storage/' . $book->cover_image)}}" alt="{{$book->title}}">
                        @else
                        No image 
                        @endif <br>
                        <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                        Category: {{ $book->category }}<br>
                        Price: {{ $book->rental_price }} Birr<br>
                        Quantity: {{ $book->quantity }}<br>
                        Status: {{ $book->status }}<br>
                    </li>
                    <form action="{{ route('books.rent', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit">Rent this book</button>
                    </form>
                @else
                <li>
                    <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                    Category: {{ $book->category }}<br>
                    Price: {{ $book->rental_price }} Birr<br>
                    Quantity: {{ $book->quantity }}<br>
                    Status: {{$book->status = 'unavailable'}}<br>
                </li>
                    
                    <p>Currently unavailable</p>
                @endif

                <hr>
            @endforeach
        </ul>
    @endif
</div>
@endsection

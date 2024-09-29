@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Available Books for Rent</h2>

    @if($books->isEmpty())
        <p>No books available for rent at the moment.</p>
    @else
    <div class="row d-flex justify-content-between">
        @foreach ($books as $book)
                
                @if($book->quantity > 0)
                <div class="card col-sm-1 col-md-2 col-lg-3 ms-4 pb-4 pt-4 ps-4 d-flex justify-content-between">
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
                    <form action="{{ route('books.rent', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Rent this book</button>
                    </form>
                </div>
                    
                @else
                <div class="card col-sm-1 col-md-2 col-lg-3 ms-4 pb-4 pt-4 ps-4 d-flex justify-content-between">
                    @if ($book->cover_image)
                        <img src="{{asset('storage/' . $book->cover_image)}}" alt="{{$book->title}}">
                    @else
                        No image 
                    @endif <br>
                    <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                    Category: {{ $book->category }}<br>
                    Price: {{ $book->rental_price }} Birr<br>
                    Quantity: {{ $book->quantity }}<br>
                    Status: {{$book->status = 'unavailable'}}<br>
                    <p>Currently unavailable</p>
                </div>
                    
                @endif

            @endforeach
    </div>
    @endif
</div>
@endsection

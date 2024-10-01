@extends('layouts.layout')

@section('content')
<div class="hero bg-primary text-white py-5 mb-4">
    <div class="container text-center">
        <h1>Welcome to the Book Rental Service</h1>
        <p class="lead">Find your next great read and rent it at an affordable price.</p>
        <a href="#available-books" class="btn btn-light btn-lg">Browse Available Books</a>
    </div>
</div>

<div class="container">
    <h2 id="available-books">Available Books for Rent</h2>

    @if($books->isEmpty())
        <p>No books available for rent at the moment.</p>
    @else
    <div class="row d-flex justify-content-between">
        @foreach ($books as $book)
            @if($book->quantity > 0)
            <div class="card col-sm-1 col-md-2 col-lg-3 ms-4 pb-4 pt-4 ps-4 d-flex justify-content-between">
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid">
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
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid">
                @else
                    No image 
                @endif <br>
                <strong>{{ $book->title }}</strong> by {{ $book->author }}<br>
                Category: {{ $book->category }}<br>
                Price: {{ $book->rental_price }} Birr<br>
                Quantity: {{ $book->quantity }}<br>
                Status: Unavailable<br>
                <p>Currently unavailable</p>
            </div>
            @endif
        @endforeach
    </div>
    @endif
    <!-- Button to apply to become an owner -->
    @if(Auth::check() && Auth::user()->role === 'renter')
        <div class="card mb-3">
            <div class="card-body text-center">
                <h4>Interested in Becoming an Owner?</h4>
                <form action="{{ route('apply.become.owner') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Apply to Become an Owner</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

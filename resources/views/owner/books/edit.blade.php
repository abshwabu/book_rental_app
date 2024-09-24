@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Edit Book</h2>
    
    <form action="{{ route('owner.books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- This is required for PUT requests -->

        <div class="form-group">
            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required>
        </div>

        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="Fiction" {{ $book->category == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                <option value="Science" {{ $book->category == 'Science' ? 'selected' : '' }}>Science</option>
                <option value="Biography" {{ $book->category == 'Biography' ? 'selected' : '' }}>Biography</option>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $book->quantity) }}" required>
        </div>

        <div class="form-group">
            <label for="rental_price">Rental Price:</label>
            <input type="number" name="rental_price" id="rental_price" value="{{ old('rental_price', $book->rental_price) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ $book->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>

        <button type="submit">Update Book</button>
    </form>
</div>
@endsection

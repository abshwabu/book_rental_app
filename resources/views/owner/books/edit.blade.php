@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Edit Book</h2>
    
    <form action="{{ route('owner.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <!-- Title input -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
        </div>
    
        <!-- Author input -->
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
        </div>
    
        <!-- Category input -->
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ $book->category }}" required>
        </div>

        <!-- Quantity input -->
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $book->quantity }}" required>
        </div>
    
        <!-- Rental Price input -->
        <div class="form-group">
            <label for="rental_price">Rental Price</label>
            <input type="number" class="form-control" id="rental_price" name="rental_price" value="{{ $book->rental_price }}" required>
        </div>
    
        <!-- Book Status input -->
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available" {{ $book->status === 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ $book->status === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>
    
        <!-- Cover Image input -->
        <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Image" width="100">
            @endif
        </div>
    
        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
    
</div>
@endsection

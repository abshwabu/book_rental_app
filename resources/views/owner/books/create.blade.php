@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Add New Book</h2>
    
    <form action="{{ route('owner.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <!-- Title input -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
    
        <!-- Author input -->
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
        </div>
    
        <!-- Category input -->
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') ?? $book->quantity ?? 1 }}" required>
        </div>
        <!-- Rental Price input -->
        <div class="form-group">
            <label for="rental_price">Rental Price</label>
            <input type="number" class="form-control" id="rental_price" name="rental_price" value="{{ old('rental_price') }}" required>
        </div>
    
        <!-- Book Status input -->
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
    
        <!-- Cover Image input -->
        <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image">
        </div>
    
        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
    
</div>
@endsection

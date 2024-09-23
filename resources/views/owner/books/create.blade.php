@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Add New Book</h2>
    
    <form action="{{ route('owner.books.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="Fiction">Fiction</option>
                <option value="Science">Science</option>
                <option value="Biography">Biography</option>
                <option value="History">History</option>
                <!-- Add other categories here -->
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1" required>
        </div>

        <div class="form-group">
            <label for="rental_price">Rental Price (in Birr):</label>
            <input type="number" name="rental_price" id="rental_price" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>

        <button type="submit">Add Book</button>
    </form>
</div>
@endsection

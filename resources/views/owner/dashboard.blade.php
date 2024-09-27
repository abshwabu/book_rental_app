@extends('layouts.layout')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Owner Dashboard</h1>

    <h3>Your Uploaded Books</h3>

    <!-- Filter and Sort Form -->
    <form method="GET" action="{{ route('owner.dashboard') }}">
        <div class="form-group">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category" class="form-control">
                <option value="">All</option>
                <option value="fiction">Fiction</option>
                <option value="non-fiction">Non-fiction</option>
                <!-- Add more categories as needed -->
            </select>
        </div>

        <div class="form-group">
            <label for="search">Search by Title:</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Search by title">
        </div>

        <div class="form-group">
            <label for="sort_by">Sort by:</label>
            <select name="sort_by" id="sort_by" class="form-control">
                <option value="title">Title</option>
                <option value="rental_price">Rental Price</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Apply</button>
    </form>

    <!-- Display Books -->
    <table class="table">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Image" width="50">
                        @else
                            No image
                        @endif
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>
                        <a href="{{ route('owner.books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection

@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    <p>Total Users: {{ $userCount }}</p>
    <p>Total Books: {{ $bookCount }}</p>

    <a href="{{ route('admin.users') }}">Manage Users</a><br>
    <a href="{{ route('admin.books') }}">Manage Books</a>
</div>
@endsection

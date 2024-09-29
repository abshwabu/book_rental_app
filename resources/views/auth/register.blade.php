@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Register</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" location="location" id="location" value="{{ old('location') }}" >
            @error('location')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" phone_number="phone_number" id="phone_number" value="{{ old('phone_number') }}" >
            @error('phone_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Register</button>
    </form>
</div>
@endsection

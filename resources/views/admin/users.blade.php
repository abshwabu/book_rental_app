@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Manage Users</h2>

    @if($users->isEmpty())
        <p>No users found.</p>
    @else
        <ul>
            @foreach ($users as $user)
                <li>
                    <strong>{{ $user->name }}</strong> ({{ $user->email }}) - Role: {{ $user->role }}
                    @if($user->role !== 'admin')
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    @endif
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</div>
@endsection

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
            <strong>{{ $user->name }}</strong> ({{ $user->email }}) - Role: {{ $user->role }} - Status: {{ $user->active ? 'Active' : 'Deactivated' }}
            
            @if($user->active)
                <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit">Deactivate</button>
                </form>
            @else
                <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit">Activate</button>
                </form>
            @endif
        </li>
        @endforeach
    </ul>
    
    @endif
</div>
@endsection

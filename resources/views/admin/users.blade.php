@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">List of Owner</h2>

    @if($users->isEmpty())
        <p>No users found.</p>
    @else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Owner</th>
                    <th>Upload</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                <tr>
                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->books->count() }} Books</td>
                    <td>{{ $user->location }}</td>
                    <td>
                        <div class="status-toggle">
                            <span class="badge {{ $user->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->active ? 'Active' : 'Deactivated' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">

                            <!-- Delete Button -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                            <!-- Approve Button -->
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
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

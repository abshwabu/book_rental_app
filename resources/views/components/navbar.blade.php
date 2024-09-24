<nav>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>

        @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @else
            @if (Auth::user()->role == 'admin')
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
            @elseif (Auth::user()->role == 'renter')
                <li><a href="{{route('renter.dashboard')}}"></a></li>
            @else
            <li><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
            @endif
            
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        @endguest
    </ul>
</nav>

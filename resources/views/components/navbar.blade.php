<nav>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>

        @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @else
            <li><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        @endguest
    </ul>
</nav>

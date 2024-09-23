<nav>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        
        @auth
            <li><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
        @else
            <li><a href="{{ route('login') }}">Login</a></li>
        @endauth
    </ul>
</nav>

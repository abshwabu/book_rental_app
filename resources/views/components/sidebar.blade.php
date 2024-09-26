<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Book Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @if (Auth::check()&&Auth::user()->role === 'admin')
        <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Manage Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Users</span>
        </a>
    </li>

    <!-- Manage Books -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.books') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Manage Books</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @elseif (Auth::user() && Auth::user()->role === 'owner')
    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('owner.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('owner.books.mybooks') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Manage Books</span>
        </a>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @else
    <li class="nav-item">
        <a class="nav-link" href="{{ route('renter.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('renter.books') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Manage Books</span>
        </a>
    </li>
    @endif
    
</ul>

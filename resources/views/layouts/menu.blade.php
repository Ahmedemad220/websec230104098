<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/even') }}">Even Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/prime') }}">Prime Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/multable') }}">Multiplication Table</a>
            </li>
            
            @role('Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users_create') }}">Add Employee</a>
            </li>
            @endrole

            {{-- Products: visible to admin, employee, and customer --}}
            @role(['Admin', 'Employee', 'customer'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products_list') }}">Products</a>
            </li>
            @endrole

            {{-- Customers: visible only to employees --}}
            @role('Employee')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('customers.list') }}">Customers</a>
            </li>
            @endrole

            {{-- Users: visible if the user has the "show_users" permission --}}
            @can('show_users')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users') }}">Users</a>
            </li>
            @endcan
            
            @can('list_orders')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.list') }}">Orders</a>
            </li>
            @endcan

            @role('customer')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.my') }}">My Orders</a>
            </li>
            @endrole

        </ul>

        {{-- Right Side: Authenticated user --}}
        <ul class="navbar-nav">
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile') }}">{{ auth()->user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
            @endauth
        </ul>
    </div>
</nav>



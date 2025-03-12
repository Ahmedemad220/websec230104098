<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./even">Even Numbers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./prime">Prime Numbers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./multable">Multable table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./minitest">Supermarket bill</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./transcript">transcript</a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('products_list') }}">Products</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('grades.index') }}">Grades</a>
        </li>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('questions.index') }}">Manage Questions</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('exam.start') }}">Start Exam</a>
            </li>
        </ul>


        <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item dropdown">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>

    </div>
</nav>

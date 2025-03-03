<header class="navigation fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-white">
            <a class="navbar-brand order-1" href="{{ url('/') }}">
                <img class="img-fluid" width="100px" src="{{ asset('user_assets/images/logo.png') }}"
                    alt="Reader | Hugo Personal Blog Template">
            </a>
            <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('questions') }}">Question & Answer</a>
                    </li>
                </ul>
            </div>

            <div class="order-2 order-lg-3 d-flex align-items-center">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            @auth
                                @if (auth()->user()->photo)
                                    <img class="rounded-circle" src="{{ asset('images/user_photos/' .auth()->user()->photo ) }}" alt="user_img" style="max-height: 35px;">
                                @else
                                    <img class="rounded-circle" src="{{ asset('images/user_photos/avatar.png' ) }}" alt="user_img" style="max-height: 35px;">
                                @endif
                            @else
                                <i class="fas fa-user-circle" style="font-size: 20px;"></i>
                            @endauth
                            <i class="ti-angle-down ml-1"></i>
                        </a>
                        <div class="dropdown-menu">

                            @auth
                                <a class="dropdown-item" href="author.html">{{ auth()->user()->name }}</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout dropdown-item">Logout</button>
                                </form>
                            @else
                                <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                            @endauth

                        </div>
                    </li>
                </ul>

                <!-- search -->
                <form class="search-bar">
                    <input id="search-query" name="s" type="search"
                        placeholder="Type &amp; Hit Enter...">
                </form>

                <button class="navbar-toggler border-0 order-1" type="button" data-toggle="collapse"
                    data-target="#navigation">
                    <i class="ti-menu"></i>
                </button>
            </div>

        </nav>
    </div>
</header>
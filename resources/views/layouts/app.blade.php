<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $pageName ?? config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        #sidebar {
            position: fixed;
            top: 72px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            width: 280px;
            transition: left .3s ease-in-out;
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar .nav-link {
            font-weight: 500;
            color: #adb5bd;
        }

        #sidebar .nav-link.active {
            color: #007bff;
        }

        #sidebar-toggle {
            display: none;
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            z-index: 110;
        }

        #sidebar-toggle span {
            font-size: 24px;
        }

        .content {
            margin-left: 280px;
            transition: margin-left .3s ease-in-out;
            padding: 20px;
            min-height: 95vh;
        }

        @media (max-width: 768px) {
            #sidebar {
                left: -280px;
            }

            #sidebar-toggle {
                display: block;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand navbar-dark bg-primary text-light shadow-sm sticky-top">
            <div class="container">
                <button id="sidebar-toggle" class="btn btn-primary">
                    <span class="material-icons">menu</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown me-3">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <img src="{{ Auth::user()->pfp ? asset(Auth::user()->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" 
                                    class="rounded-circle" 
                                    style="width: 40px; height: 40px;" 
                                    alt="User Profile Picture">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show', Auth::id()) }}">Profil</a>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @auth
        <div id="sidebar" class="bg-dark text-light sticky-start">
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="{{ route('post.index')}}" class="nav-link text-light">
                        <i class="material-icons">public</i>
                        public
                    </a>
                </li>                
                <li>
                    <a href="{{ route('post.followed')}}" class="nav-link text-light ">
                        <i class="material-icons">person</i>
                        Followed
                    </a>
                </li>
                <li>
                    <a href="{{ route('post.friend')}}" class="nav-link text-light ">
                        <i class="material-icons">groups</i>
                        Friends
                    </a>
                </li>
                <li>
                    <a href="{{ route('post.create')}}" class="nav-link text-light">
                        <i class="material-icons">post_add</i>
                        Create Post
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6 class="nav-link">
                    Followed Friends
                </h6>
                @foreach (Auth::user()->following as $followed)
                    @if($followed->following->hasFriendshipWith(Auth::id()))
                    <li class="nav-link">
                        <div class="d-flex mr-3">
                            <a class="text-light" style="text-decoration: none" href="{{ route('profile.show', $followed->following->id) }}">
                                <img src="{{ $followed->following->pfp ? asset($followed->following->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $followed->following->name }}" class="rounded-circle mr-2" style="object-fit: cover; width: 30px; height: 30px;">
                            </a>
                            <div class="flex-grow-1">
                                <a class="text-light" style="text-decoration: none" href="{{ route('profile.show', $followed->following->id) }}">
                                    <h6 class="font-weight-bold mb-0">{{ $followed->following->name }}</h6>
                                </a>
                            </div>
                        </div>
                    </li>
                    @endif
                @endforeach                
            </ul>
            <ul class="nav nav-pills flex-column mb-auto">
                <h6 class="nav-link">
                    Followed Profile
                </h6>
                @foreach (Auth::user()->following as $followed)
                    <li class="nav-link">
                        <div class="d-flex mr-3">
                            <a class="text-light" style="text-decoration: none" href="{{ route('profile.show', $followed->following->id) }}">
                                <img src="{{ $followed->following->pfp ? asset($followed->following->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $followed->following->name }}" class="rounded-circle mr-2" style="object-fit: cover; width: 30px; height: 30px;">
                            </a>
                            <div class="flex-grow-1">
                                <a class="text-light" style="text-decoration: none" href="{{ route('profile.show', $followed->following->id) }}">
                                    <h6 class="font-weight-bold mb-0">{{ $followed->following->name }}</h6>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
                
            </ul>
        </div>

        <main class="content">
        @else
        <main style="min-height: 95vh;">
        @endauth

        @if(Session::has('success'))
            <div class="pt-3">
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif

        @if(Session::has('warning'))
            <div class="pt-3">
                <div class="alert alert-warning">
                    {{ Session::get('warning') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="pt-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

            @yield('content')

        </main>
            <!-- Footer Section -->
            <footer class="mt-5 py-4 bg-dark text-white text-center">
                <p>&copy; 2024 Sevalino Elfata. All rights reserved.</p>
                {{-- <p>Follow us on <a href="#" class="text-light">Facebook</a>, <a href="#" class="text-light">Twitter</a>, and <a href="#" class="text-light">Instagram</a>.</p> --}}
            </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        });
    </script>
    @yield('script')
</body>
</html>

dfore
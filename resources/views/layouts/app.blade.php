<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
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
            background-color: #343a40;
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
            }

        }
    </style>
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand navbar-dark bg-dark shadow-sm sticky-top">
            <div class="container">
                <button id="sidebar-toggle" class="btn btn-dark">
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
                            <li class="nav-item dropdown mx-3">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <img src="{{ Auth::user()->pfp ? asset(Auth::user()->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" 
                                    class="rounded-circle" 
                                    style="width: 40px; height: 40px;" 
                                    alt="User Profile Picture">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a>
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
        <div id="sidebar" class="bg-dark text-light">
            <ul class="nav nav-pills flex-column mb-auto">
                <li>
                    <a href="{{ url('/post')}}" class="nav-link text-light">
                        <i class="material-icons">mms</i>
                        All Post
                    </a>
                </li>
                <li>
                    <a href="{{ url('/post/create')}}" class="nav-link text-light">
                        <i class="material-icons">post_add</i>
                        Create Post
                    </a>
                </li>
            </ul>
        </div>

        <main class="py-4 content">
        @else
        <main class="py-4">
        @endauth

            @if($errors->any())
                <div class="pt-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

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
            @yield('content')
        </main>
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

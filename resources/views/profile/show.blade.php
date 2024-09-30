<!-- resources/views/profile/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="justify-content-center">
            <div class="container-fluid">
                <div class="card border-4 shadow-lg rounded-4 bg-dark text-light">
                    <div class="card-header bg-secondary text-light text-center p-4 rounded-top">
                        <h2 class="mb-0">{{ $user->name }}'s Profile</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="d-flex align-items-center mb-4">                                    
                                    <div class="me-4">
                                        <img src="{{ $user->pfp ? asset($user->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" 
                                             class="rounded-circle border border-4 border-light shadow-sm" 
                                             style="width: 150px; height: 150px;" 
                                             alt="User Profile Picture">
                                    </div>
                                    <div>
                                        <h3>{{ $user->name }}</h3>
                                        <p class="text-muted">{{ $user->email }}</p>
                                        <p>{{ $user->bio ?? 'No bio available.' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="d-flex justify-content-center space-x-4 row">
                                    <div class="w-50 text-center">
                                        <h5>{{ $user->followers->count() }}</h5>
                                        <p>Followers</p>
                                    </div>
                                    <div class="w-50 text-center">
                                        <h5>{{ $user->following->count() }}</h5>
                                        <p>Following</p>
                                    </div>
                                </div>
                                @if (Auth::user()->isFollowing($user->id))
                                    <form method="POST" action="{{ route('profile.unfollow') }}" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Unfollow') }}
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('profile.follow') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Follow') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @auth
                            @if(Auth::user()->id === $user->id)
                                <div class="text-center mt-4">
                                    <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">
                                        {{ __('Edit Profile') }}
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>

                <nav class="mt-4">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-posts" type="button" role="tab" aria-controls="nav-posts" aria-selected="true">Posts</button>
                        <button class="nav-link" id="nav-saved-tab" data-bs-toggle="tab" data-bs-target="#nav-saved" type="button" role="tab" aria-controls="nav-saved" aria-selected="false">Saved</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" style="max-width: 480px; margin: 0 auto;">
                    <div class="tab-pane fade show active" id="nav-posts" role="tabpanel" aria-labelledby="nav-posts-tab">
                        @foreach($posts as $post)
                            @component('components.post-item', ['posts' => true, 'post' => $post, 'commentDropdown' => true])
                            @endcomponent
                        @endforeach
                        <div class="mt-4">
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-saved" role="tabpanel" aria-labelledby="nav-saved-tab">
                        @foreach($savedPosts as $post)
                            @component('components.post-item', ['posts' => true, 'post' => $post, 'commentDropdown' => true])
                            @endcomponent
                        @endforeach
                        <div class="mt-4">
                            {{ $savedPosts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .card-header {
            background: linear-gradient(90deg, rgba(33,37,41,1) 0%, rgba(47,54,64,1) 100%);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 0.375rem; /* Rounded corners */
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
@endsection


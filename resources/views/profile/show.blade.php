<!-- resources/views/profile/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4 bg-dark text-light">
                    <div class="card-header bg-secondary text-light text-center p-4 rounded-top">
                        <h2 class="mb-0">{{ $user->name }}'s Profile</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-4">
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
                
                <div class="container" style="max-width: 480px; margin: 0 auto;">
                    @foreach($posts as $post)
                        @component('components.post-item', ['post' => $post])
                        @endcomponent
                    @endforeach
                    <div class="mt-4">
                        {{ $posts->links('pagination::bootstrap-5') }}
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

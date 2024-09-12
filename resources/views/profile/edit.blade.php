<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4 bg-dark text-light">
                    <div class="card-header bg-dark text-light text-center p-4 rounded-top">
                        <h2 class="mb-0">{{ __('Edit Profile') }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- Profile Picture Section -->
                            <div class="d-flex align-items-start mb-5">
                                <div class="me-4">
                                    <img src="{{ Auth::user()->pfp ? asset(Auth::user()->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" 
                                         class="rounded-circle border border-4 border-light shadow-sm" 
                                         style="width: 150px; height: 150px;" 
                                         alt="User Profile Picture">
                                </div>
                                <div class="flex-grow-1">
                                    <input id="pfp" type="file" class="form-control @error('pfp') is-invalid @enderror" name="pfp">
                                    <label for="pfp" class="btn btn-outline-light mt-2 w-100">
                                        {{ __('Upload New Profile Picture') }}
                                    </label>
                                </div>
                            </div>

        

                            <!-- Form Fields Section -->
                            <div class="mb-4">
                                @foreach(['name', 'bio', 'email', 'password', 'password_confirmation'] as $field)
                                    <div class="mb-3">
                                        <label for="{{ $field }}" class="form-label">{{ __("{$field}") }}</label>
                                        @if($field === 'email')
                                            <input id="{{ $field }}" type="email" class="form-control bg-secondary text-light" name="{{ $field }}" value="{{ Auth::user()->{$field} }}" readonly>
                                        @elseif($field === 'password')
                                            <input id="{{ $field }}" type="password" class="form-control bg-secondary text-light @error($field) is-invalid @enderror" name="{{ $field }}">
                                        @elseif($field === 'password_confirmation')
                                            <input id="{{ $field }}" type="password" class="form-control bg-secondary text-light" name="{{ $field }}">
                                        @elseif ($field === 'bio')
                                            <textarea id="{{ $field }}" class="form-control bg-secondary text-light @error('bio') is-invalid @enderror" name="{{ $field }}" rows="4" placeholder="Tell us about yourself">{{ old('bio', Auth::user()->bio) }}</textarea>
                                        @else
                                            <input id="{{ $field }}" type="text" class="form-control bg-secondary text-light @error($field) is-invalid @enderror" name="{{ $field }}" value="{{ Auth::user()->{$field} }}" required>
                                        @endif

                                        @error($field)
                                            <div class="invalid-feedback d-block mt-2">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <!-- Submit Button Section -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .card-header {
            background: linear-gradient(90deg, rgba(0,0,0,1) 0%, rgba(34,34,34,1) 100%);
        }
        .btn-outline-light {
            border: 2px solid rgba(255,255,255,0.5);
            color: rgba(255,255,255,0.5);
        }
        .btn-outline-light:hover {
            background-color: rgba(255,255,255,0.1);
            color: rgba(255,255,255,1);
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
        .form-control.bg-secondary {
            background-color: #343a40;
            color: #f8f9fa;
        }
        .form-control.bg-secondary::placeholder {
            color: #6c757d;
        }
    </style>
@endsection

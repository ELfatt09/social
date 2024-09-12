<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-light">
                        <h2>{{ __('Edit Profile') }}</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- Profile Picture Section -->
                            <div class="mb-4">
                                <h5>{{ __('Profile Picture') }}</h5>
                                <div class="profile-picture">
                                    <img src="{{ Auth::user()->pfp ? asset(Auth::user()->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" 
                                         class="rounded-circle" 
                                         style="width: 120px; height: 120px;" 
                                         alt="User Profile Picture">
                                </div>
                                <div class="upload-button">
                                    <input id="pfp" type="file" class="form-control @error('pfp') is-invalid @enderror" name="pfp">
                                    <label for="pfp" class="btn btn-primary bg-dark text-light">{{ __('Upload New Profile Picture') }}</label>
                                </div>
                            </div>

                            <!-- Form Fields Section -->
                            <div class="form-fields-section">
                                @foreach(['name', 'email'] as $field)
                                    <div class="form-group row">
                                        <label for="{{ $field }}" class="col-md-4 col-form-label text-md-right">{{ __("{$field}") }}</label>

                                        <div class="col-md-6">
                                            @if($field === 'email')
                                                <input id="{{ $field }}" type="email" class="form-control" name="{{ $field }}" value="{{ Auth::user()->{$field} }}" readonly>
                                            @else
                                                <input id="{{ $field }}" type="text" class="form-control @error($field) is-invalid @enderror" name="{{ $field }}" value="{{ Auth::user()->{$field} }}" required>
                                            @endif

                                            @error($field)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Submit Button Section -->
                            <div class="submit-button-section">
                                <button type="submit" class="btn btn-primary bg-dark text-light">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
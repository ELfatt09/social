@extends('layouts.app')

@section('content')
<section class="bg-light py-3 py-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <h1 class="display-6 text-center">Sign Up</h1>
                        <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Create your account</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row gy-2 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Your Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        <label for="name" class="form-label">Name</label>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email">
                                        <label for="email" class="form-label">Email Address</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                        <label for="password" class="form-label">Password</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                        <label for="password-confirm" class="form-label">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid my-3">
                                        <button class="btn btn-dark btn-lg" type="submit">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center justify-content-center text-center text-white" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                url('/dashboard/image.png') center/cover no-repeat; height: 100vh;">
        <div class="hero-content">
            <h1 class="display-3 fw-bold">Welcome to GREDIA</h1>
            <p class="lead">Connect, Share, and Engage in Real Time.</p>
            <a href="#features" class="btn btn-primary btn-lg mt-4 cta-btn">Discover More</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Features</h2>
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="feature-card p-4 shadow-sm rounded">
                        <i class="fas fa-pencil-alt fa-3x mb-3 text-primary"></i>
                        <h4>Post</h4>
                        <p>Create and share your thoughts with the world. Engage with a community of like-minded individuals.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="feature-card p-4 shadow-sm rounded">
                        <i class="fas fa-comments fa-3x mb-3 text-success"></i>
                        <h4>Comment</h4>
                        <p>Share your thoughts on posts and start conversations. Your voice matters in every discussion.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="feature-card p-4 shadow-sm rounded">
                        <i class="fas fa-user-plus fa-3x mb-3 text-danger"></i>
                        <h4>Follow</h4>
                        <p>Stay updated with your favorite users. Get notifications and see their latest posts in your feed.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="feature-card p-4 shadow-sm rounded">
                        <i class="fas fa-comments-dollar fa-3x mb-3 text-info"></i>
                        <h4>Real-Time Chat</h4>
                        <p>Chat with friends instantly. Enjoy seamless real-time messaging right within the app.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">How It Works</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="step">
                        <i class="fas fa-sign-in-alt fa-4x mb-3 text-primary"></i>
                        <h4>Sign Up</h4>
                        <p>Create your account quickly and easily. Join a vibrant community of users.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="step">
                        <i class="fas fa-pen fa-4x mb-3 text-success"></i>
                        <h4>Post and Comment</h4>
                        <p>Start posting content and engaging with others by commenting on posts.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="step">
                        <i class="fas fa-users fa-4x mb-3 text-danger"></i>
                        <h4>Follow and Chat</h4>
                        <p>Follow users to see their updates and chat with friends in real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section id="cta" class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="mb-4">Ready to Get Started?</h2>
            <p>Join GREDIA today and be part of an engaging community.</p>
            <a href="{{ route('register')}}" class="btn btn-primary btn-lg mt-4 cta-btn">Sign Up Now</a>
        </div>
    </section>

    <section id="team" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-5">About the Developer</h2>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="team-member shadow-sm p-3 rounded">
                        <img src="{{ url('/dashboard/yuta.jpg') }}" width="150" height="150" class="rounded-circle mb-3" alt="Your Name">
                        <h5>Sevalino Elfata</h5>
                        <p>Lead Developer and Creator</p>
                        <p>Passionate about building innovative solutions and creating engaging user experiences. GREDIA is a personal project aimed at revolutionizing social connections.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Additional Styles -->
<style>
    .hero-section {
        background-attachment: fixed;
        animation: backgroundAnimation 10s ease-in-out infinite alternate;
    }
    @keyframes backgroundAnimation {
        0% { background-position: center; }
        100% { background-position: center top; }
    }
    .feature-card, .step {
        transition: transform 0.3s ease;
    }
    .feature-card:hover, .step:hover {
        transform: translateY(-10px);
    }
    footer a {
        color: #ff6f61;
        text-decoration: none;
    }
    footer a:hover {
        text-decoration: underline;
    }
</style>

<!-- Optional JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init(); // Initialize AOS animations
    
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection



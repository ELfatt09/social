<!-- resources/views/post/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: 0 auto;">
    <div class="bg-dark text-white p-4 border border-secondary shadow-sm rounded my-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="author-info d-flex align-items-center">
                <div class="ml-2">
                    <h5 class="font-weight-bold">
                        <img src="{{ $post->author->pfp ? asset($post->author->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $post->author->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                        {{ $post->author->name }}
                    </h5>
                    <p class="text-muted mb-0">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        <h2 class="font-weight-bold mb-3">{{ $post->title }}</h2>
        <p class="text-justify mb-4">{{ $post->body }}</p>
        @if($post->media->count() > 0)
            <div class="container-fluid p-3 mb-4">
                @if($post->media->count() == 1)
                    @foreach($post->media as $media)
                        @if(Str::startsWith($media->mime_type, 'image/'))
                            <img src="{{ $media->file_path }}" alt="{{ $media->file_name }}" class="img-thumbnail d-block w-100">
                        @endif
                    @endforeach
                @else
                    <div id="mediaCarousel-{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-dark d-flex flex-row flex-wrap justify-content-between align-items-center" style="height: 400px;">
                            @foreach($post->media as $media)
                                @if(Str::startsWith($media->mime_type, 'image/'))
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ $media->file_path }}" alt="{{ $media->file_name }}" class="d-block mx-auto" style="max-height: 400px; object-fit: cover; width: auto;">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel-{{ $post->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel-{{ $post->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif
        <a class="text-light" href="{{ url('/post') }}">Back to posts</a>
        <div class="container-md">
            
        </div>
    </div>
</div>
@endsection

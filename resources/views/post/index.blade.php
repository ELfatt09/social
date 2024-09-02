@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px; margin: 0 auto;">
@foreach($posts as $post)
    <div class="bg-white p-4 border shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="author-info d-flex align-items-center">
                <img src="{{ $post->author->pfp ? asset($post->author->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $post->author->name }}" class="rounded-circle mr-2" style="width: 40px; height: 40px;">
                <div class="ml-2">
                    <h5 class="font-weight-bold">{{ $post->author->name }}</h5>
                    <p class="text-muted" style="margin-bottom: 0;">{{ $post->created_at->diffForHumans() }}</p>
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
                    <!-- Create a carousel to display all image files -->
                    <div id="mediaCarousel-{{ $post->id }}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner bg-secondary">
                            @foreach($post->media as $media)
                                @if(Str::startsWith($media->mime_type, 'image/'))
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img class="img-fluid mx-auto" src="{{ $media->file_path }}" alt="{{ $media->file_name }}" class="d-block" style="max-height: 400px;width: auto;">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel-{{ $post->id }}"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </div>
                    <div class="carousel-control-next" type="button" data-bs-target="#mediaCarousel-{{ $post->id }}"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </div>

                    </div>
                @endif
            </div>
        @endif
        <div class="post-actions d-flex justify-content-between align-items-center">
            <button class="btn btn-sm btn-outline-primary">Like</button>
            <button class="btn btn-sm btn-outline-secondary">Comment</button>
            <button class="btn btn-sm btn-outline-success">Share</button>
        </div>
    </div>
    <script>
        $(document).ready(function() {
          $('.carousel').carousel();
        });
      </script>
@endforeach
@endsection
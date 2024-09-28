<div class="post-item bg-white rounded-4 shadow-sm p-4 mb-4">
    <div class="d-flex align-items-center mb-4">
        <div class="author-info d-flex align-items-center mr-3">
            <a href="{{ route('profile.show', $post->author->id) }}" class="text-dark" style="text-decoration: none">
                <img src="{{ $post->author->pfp ? asset($post->author->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $post->author->name }}" class="rounded-circle" style="width: 40px; height: 40px;">
            </a>
            <div class="ml-2">
                <p class="text-dark font-weight-bold mb-0">{{ $post->author->name }}</p>
                <p class="text-muted mb-0">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
    <h2 class="font-weight-bold mb-3">{{ $post->title }}</h2>
    <div class="container-fluid p-3 mb-4">
        @if($post->media->count() > 0)
            @if($post->media->count() == 1)
                @foreach($post->media as $media)
                    @if(Str::startsWith($media->mime_type, 'image/'))
                        <img src="{{ $media->file_path }}" alt="{{ $media->file_name }}" class="img-thumbnail d-block w-100">
                    @endif
                @endforeach
            @else
                <div id="media-carousel-{{ $post->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner bg-light d-flex flex-row flex-wrap justify-content-between align-items-center" style="height: 400px;">
                        @foreach($post->media as $media)
                            @if(Str::startsWith($media->mime_type, 'image/'))
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ $media->file_path }}" alt="{{ $media->file_name }}" class="d-block w-auto h-100 mx-auto" style="max-height: 400px; max-width: 100%;">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#media-carousel-{{ $post->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#media-carousel-{{ $post->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @endif
        @endif
    </div>
    <div class="btn-group align-end" role="group" style="column-gap: 5px;">
        <form action="{{ $post->isRespondedBy(Auth::user(), 'upvote') ? route('post.response.destroy') : route('post.response') }}" method="post" style="display: inline-block;">
            @csrf
            @if($post->isRespondedBy(Auth::user(), 'upvote'))
                @method('DELETE')
            @else
                @method('POST')
            @endif
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="action" value="upvote">
            <button type="submit" class="btn btn-outline-primary {{ $post->isRespondedBy(Auth::user(), 'upvote') ? 'active' : '' }}" style="display: inline-block;"><span class="material-icons align-middle">arrow_upward</span>{{ number_format((int) $post->upvote_count, 0, '.', ' ') > 1000000 ? number_format((int) $post->upvote_count / 1000000, 1) . 'm' : (number_format((int) $post->upvote_count, 0, '.', ' ') > 1000 ? number_format((int) $post->upvote_count / 1000, 1) . 'k' : $post->upvote_count ?? 0) }}</button>
        </form>
        <form action="{{ $post->isRespondedBy(Auth::user(), 'downvote') ? route('post.response.destroy') : route('post.response') }}" method="post" style="display: inline-block;">
            @csrf
            @if($post->isRespondedBy(Auth::user(), 'downvote'))
                @method('DELETE')
            @else
                @method('POST')
            @endif
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="action" value="downvote">
            <button type="submit" class="btn btn-outline-danger {{ $post->isRespondedBy(Auth::user(), 'downvote') ? 'active' : '' }}" style="display: inline-block;"><span class="material-icons align-middle">arrow_downward</span>{{ number_format((int) $post->downvote_count, 0, '.', ' ') > 1000000 ? number_format((int) $post->downvote_count / 1000000, 1) . 'm' : (number_format((int) $post->downvote_count, 0, '.', ' ') > 1000 ? number_format((int) $post->downvote_count / 1000, 1) . 'k' : $post->downvote_count ?? 0) }}</button>
        </form>
        <form action="{{ $post->isRespondedBy(Auth::user(), 'star') ? route('post.response.destroy') : route('post.response') }}" method="post" style="display: inline-block;">
            @csrf
            @if($post->isRespondedBy(Auth::user(), 'star'))
                @method('DELETE')
            @else
                @method('POST')
            @endif
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="action" value="star">
            <button type="submit" class="btn btn-outline-warning {{ $post->isRespondedBy(Auth::user(), 'star') ? 'active' : '' }}" style="display: inline-block;"><span class="material-icons align-middle">star</span>{{ number_format((int) $post->star_count, 0, '.', ' ') > 1000000 ? number_format((int) $post->star_count / 1000000, 1) . 'm' : (number_format((int) $post->star_count, 0, '.', ' ') > 1000 ? number_format((int) $post->star_count / 1000, 1) . 'k' : $post->star_count ?? 0) }}</button>
        </form>
        <form action="{{ $post->isRespondedBy(Auth::user(), 'save') ? route('post.response.destroy') : route('post.response') }}" method="post" style="display: inline-block;">
            @csrf
            @if($post->isRespondedBy(Auth::user(), 'save'))
                @method('DELETE')
            @else
                @method('POST')
            @endif
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="action" value="save">
            <button type="submit" class="btn btn-outline-success {{ $post->isRespondedBy(Auth::user(), 'save') ? 'active' : '' }}" style="display: inline-block;"><span class="material-icons align-middle">bookmark</span>{{ number_format((int) $post->save_count, 0, '.', ' ') > 1000000 ? number_format((int) $post->save_count / 1000000, 1) . 'm' : (number_format((int) $post->save_count, 0, '.', ' ') > 1000 ? number_format((int) $post->save_count / 1000, 1) . 'k' : $post->save_count ?? 0) }}</button>
        </form>
    </div>        
    <p class="text-justify mb-4"><x-linkify-content :content="$post->body" /></p>    <div class="d-flex justify-content-end mt-4">        
        @if($posts)
        <a href="/post/{{ $post->id }}" class="btn btn-outline-primary me-3 align-middle d-flex align-items-center">
            <span class="material-icons align-middle">description</span>
            <span class="align-middle">detail</span>
        </a>
        @endif
        @if ($commentDropdown)
        <button class="btn btn-outline-primary me-3 align-middle d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#commentSection-{{ $post->id }}" aria-expanded="false" aria-controls="commentSection-{{ $post->id }}">
            <span class="material-icons align-middle">comment</span>
            <span class="align-middle">Komentar</span>
        </button>
        @endif
        @if ($post->user_id == Auth::id())
        <form action="{{ url('/post/delete') }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <input type="hidden" name="post" value="{{ $post->id }}">
            <button type="submit" class="btn btn-outline-danger align-middle d-flex align-items-center">
                <span class="material-icons align-middle">delete_outline</span>
                <span class="align-middle">Hapus</span>
            </button>
        </form>
        @endif
    </div>

    <!-- Logika untuk commentDropdown -->
    @if ($commentDropdown)
    <div class="collapse" id="commentSection-{{ $post->id }}">
        <div class="card bg-light p-3 mt-4">
            <h5 class="font-weight-bold mb-3">{{ $post->comment->count() }} Comments</h5>
            @component('components.comment-section', ['post' => $post])
            @endcomponent
        </div>
    </div>
    @else
    <div id="commentSection-{{ $post->id }}">
        <div class="card bg-light p-3 mt-4">
            <h5 class="font-weight-bold mb-3">{{ $post->comment->count() }} Comments</h5>

            @component('components.comment-section', ['post' => $post])
            @endcomponent
        </div>
    </div>
    @endif
</div>


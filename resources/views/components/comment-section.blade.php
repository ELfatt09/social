<div style="max-height: 500px; overflow-y: auto;">
@foreach($post->comment as $comment)
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body p-2">
        <div class="d-flex">
            <a class="text-dark" style="text-decoration: none" href="{{ route('profile.show', $comment->author->id) }}">
                <img src="{{ $comment->author->pfp ? asset($comment->author->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $comment->author->name }}" class="rounded-circle mr-2" style="object-fit: cover; width: 40px; height: 40px;">
            </a>
            <div class="flex-grow-1">
                <a class="text-dark" style="text-decoration: none" href="{{ route('profile.show', $comment->author->id) }}">
                    <h6 class="font-weight-bold mb-0">{{ $comment->author->name }}</h6>
                </a>
                <p class="text-muted mb-0">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <p class="comment-text mt-2">{{ $comment->body }}</p>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-light border-0 p-1 reply-btn" onclick="replyForm({{ $comment->id }})"data-comment-id="{{ $comment->id }}">Balas</button>
        </div>
    </div>
    <form class="reply-form d-none" id="reply-form-{{ $comment->id }}" action="{{ route('post.comment.reply') }}" method="post">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <div class="input-group w-100 p-2 rounded-pill">
            <input type="text" name="comment" placeholder="Add a reply..." class="form-control border-1 rounded-pill" style="background-color: #f8f9fa;">
            <div class="input-group-append">
                <button type="submit" class="btn btn-light border-0 rounded-0"><span class="material-icons">
                    send
                    </span>
                </button>
            </div>
        </div>
    </form>
    @foreach ($comment->replies as $reply)
    <div class="card mb-3 border-0 shadow-sm" style="margin-left: 10%;">
        <div class="card-body p-2">
            <div class="d-flex">
                <a class="text-dark" style="text-decoration: none" href="{{ route('profile.show', $reply->author->id) }}">
                    <img src="{{ $reply->author->pfp ? asset($reply->author->pfp->file_path) : asset('storage/uploads/OIP (1).jpg') }}" alt="{{ $reply->author->name }}" class="rounded-circle mr-2" style="object-fit: cover; width: 40px; height: 40px;">
                </a>
                <div class="flex-grow-1">
                    <a class="text-dark" style="text-decoration: none" href="{{ route('profile.show', $reply->author->id) }}">
                        <h6 class="font-weight-bold mb-0">{{ $reply->author->name }}</h6>
                    </a>
                    <p class="text-muted mb-0">{{ $reply->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <p class="comment-text mt-2">{{ $reply->body }}</p>
        </div>
    </div>
    @endforeach
</div>
@endforeach
</div>

<script>
    function replyForm(commentId){
        document.getElementById('reply-form-' + commentId).classList.remove('d-none');
    }
</script>

<form action="{{ route('post.comment') }}" method="post">
    @csrf
    <input id="type" class="d-none" type="hidden" name="post_id" value="{{ $post->id }}">
    <div class="input-group w-100 p-2 rounded-pill">
        <input type="text" name="comment" placeholder="Add a comment..." class="form-control border-1 rounded-pill" style="background-color: #f8f9fa;">
        <div class="input-group-append">
            <button type="submit" class="btn btn-light border-0 rounded-0"><span class="material-icons">
                send
                </span>
            </button>
        </div>
    </div>
</form>


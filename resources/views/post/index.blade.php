@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px; margin: 0 auto;">
    @foreach($posts as $post)
        @component('components.post-item', ['post' => $post])
        @endcomponent
    @endforeach
    <div class="mt-4">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

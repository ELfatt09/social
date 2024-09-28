<!-- resources/views/post/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: 0 auto;">
            @component('components.post-item', ['posts'=> false, 'post' => $post, 'commentDropdown'=>false])
            @endcomponent
</div>
@endsection

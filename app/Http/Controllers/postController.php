<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('author', 'media', 'comment')
            ->latest()
            ->paginate(10);

        return view('post.index', compact('posts'))->with(['pageName'=>'All Post']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create')->with(['pageName'=>'Create New Post']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'nullable|string|max:1000',
            'media' => 'nullable|array',
            'media.*' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,video/mp4,video/avi,video/mpeg,video/quicktime|max:102400',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                mediaController::store($file, 'post_id', $post->id);
            }
        }

        return redirect()->route('post.index')->with('success', 'Post created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('author', 'media', 'comment')->findOrFail($id);

        return view('post.show', compact('post'))->with(['pageName'=>$post->title]);;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $filename = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');

            if ($post->media) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->media->file_path));
                $post->media()->delete();
            }

            Media::create([
                'post_id' => $post->id,
                'file_type' => $file->getMimeType(),
                'file_name' => $filename,
                'file_path' => '/storage/'.$filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('post.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $postId = $request->validate([
            'post' => 'required|integer|exists:posts,id',
        ])['post'];

        $post = Post::with('author', 'media')->findOrFail($postId);

        if (! $this->canDeletePost($post)) {
            throw new AuthorizationException;
        }

        $this->deletePostMedia($post);
        $post->delete();

        return redirect()->route('post.index')->with('warning', 'Post deleted successfully');
    }

    /**
     * Determines if the current authenticated user can delete the given post.
     *
     * @param  Post  $post  The post to check deletion permissions for.
     * @return bool True if the user can delete the post, false otherwise.
     */
    private function canDeletePost(Post $post): bool
    {
        return $post->user_id === Auth::id();
    }

    /**
     * Deletes the media associated with a given post.
     *
     * @param  Post  $post  The post whose media is to be deleted.
     */
    private function deletePostMedia(Post $post): void
    {
        if ($post->media) {
            foreach ($post->media as $media) {
                mediaController::delete($media);
            }
            $post->media()->delete();
        }
    }
}

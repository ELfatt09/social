<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        // Mengambil semua post beserta media dan author terkait
        $posts = Post::with('media', 'author')->latest()->paginate(10);

        return view('post.index', ['posts' => $posts,]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'media' => 'nullable|array', // Max 20MB
            'media.*' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif'
        ]);

        // Buat post baru
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(), // or auth()->user()->id
        ])->fresh();

        // Cek apakah ada file media yang diunggah
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {      
                $fileName = time() . '_' . $media->getClientOriginalName();
                $filePath = $media->storeAs('uploads', $fileName, 'public');
        
                // Simpan informasi media ke database
                Media::create([
                    'post_id' => $post->id,
                    'file_type' => $media->getClientOriginalExtension(),
                    'file_name' => $fileName,
                    'file_path' => '/storage/' . $filePath,
                    'mime_type' => $media->getMimeType(),
                    'file_size' => $media->getSize(),
                ]);
            }
        }

        return redirect()->route('post.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        // Ambil post berdasarkan ID
        $post = Post::with('author', 'media')->findOrFail($id);

        // Kirim data ke view
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validasi data input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480', // Max 20MB
        ]);

        // Update post yang ada
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Cek apakah ada file media baru yang diunggah
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            // Hapus file media lama jika ada
            if ($post->media) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->media->file_path));
                $post->media()->delete();
            }

            // Simpan informasi media baru ke database
            Media::create([
                'post_id' => $post->id,
                'file_type' => $file->getMimeType(),
                'file_name' => $fileName,
                'file_path' => '/storage/' . $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this post');
        }
        // Hapus file media jika ada
        if ($post->media) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->media->file_path));
            $post->media()->delete();
        }

        // Hapus post
        $post->delete();

        return redirect()->route('posts.index')->with('warning', 'Post deleted successfully');
    }
}

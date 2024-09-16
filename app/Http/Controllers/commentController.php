<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Handle an incoming comment creation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createComment(Request $request)
    {
        // Validate the request body.
        $validatedData = $request->validate([
            "post_id" => "required|integer",
            "comment" => "required|string|max:1000",
        ]);

        try {
            $comment = $this->makeComment($validatedData, Auth::id());
            return redirect()->intended()->with('success', 'Comment created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['comment' => 'Failed to create comment. Please try again.']);
        }
    }

    /**
     * Create a new comment instance after a valid request.
     *
     * @param  array  $data  The data from the request.
     * @param  int  $authorId  The ID of the user who is creating the comment.
     * @return \App\Models\Comment
     */
    private function makeComment(array $data, int $authorId)
    {
        // Add authorization check to ensure the user has permission to create comments on the specified post
        $post = Post::find($data['post_id']);
        if (!$post || !$post->canBeCommentedBy(Auth::user())) {
            throw new \Exception('You do not have permission to create comments on this post.');
        }

        // Sanitize the comment input to prevent XSS attacks
        $commentBody = strip_tags($data['comment']);

        return Comment::create([
            'post_id' => $data['post_id'],
            'body' => $commentBody,
            'user_id' => $authorId,
        ]);
    }
}
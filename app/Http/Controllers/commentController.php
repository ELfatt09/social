<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Handle an incoming comment creation request.
     *
     * This method validates the comment request input and creates a new comment.
     * If the comment is created successfully, it redirects the user back to the post page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request body.
        $validatedData = $request->validate([
            "post_id" => "required|integer",
            "comment" => "required|string|max:1000",
        ]);

        // Create the comment.
        try {
            $this->makeComment($validatedData, Auth::id());

            // Redirect the user back to the post page with a success message.
            return redirect()->route('post.show', ['id' => $validatedData['post_id']])->with('success', 'Comment created successfully!');
        } catch (\Exception $e) {
            // Log the exception and return a 500 status code.
            Log::error($e->getMessage());
            return response("Error creating comment.", 500);
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

        // Sanitize the comment input to prevent XSS attacks
        $commentBody = strip_tags($data['comment']);

        return Comment::create([
            'post_id' => $data['post_id'],
            'body' => $commentBody,
            'user_id' => $authorId,
        ]);
    }



    public function destroy(Request $request)
    {
        $commentId = $request->validate([
            'id' => 'required|integer',
        ])['id'];

        Comment::findOrFail($commentId)->delete();

        return redirect()->back()->with('warning', 'Comment deleted successfully!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Validate the comment request input and create a new comment or reply.
     * If the comment is created successfully, it redirects the user back to the post page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateInput($request, 'post_id');

        try {
            $comment = $this->createComment($request->all(), Auth::id());

            return redirect()->route('post.show', ['id' => $comment->post_id])
                ->with('success', 'Comment created successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response("Error creating comment.", 500);
        }
    }

    public function reply(Request $request)
    {
        $this->validateInput($request, 'parent_id');

        try {
            $comment = $this->createComment($request->all(), Auth::id());

            return back()->with('success', 'Reply created successfully!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response("Error creating comment.", 500);
        }
    }

    /**
     * Validate the comment request input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $parentKey  The key of the parent comment ID.
     * @return void
     */
    private function validateInput(Request $request, string $parentKey)
    {
        $request->validate([
            $parentKey => 'required|integer',
            'comment' => 'required|string|max:1000',
        ]);
    }

    /**
     * Create a new comment instance after a valid request.
     *
     * @param  array  $data  The data from the request.
     * @param  int  $authorId  The ID of the user who is creating the comment.
     * @return \App\Models\Comment
     */
    private function createComment(array $data, int $authorId)
    {
        $commentBody = strip_tags($data['comment']);

        return Comment::create([
            'post_id' => $data['post_id'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
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

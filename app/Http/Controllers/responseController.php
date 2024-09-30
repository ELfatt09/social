<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ResponseController
 * @package App\Http\Controllers
 */
class ResponseController extends Controller
{
    /**
     * Create a new response after a valid request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function store(Request $request)
    {
        // Validate the request body.
        $request->validate([
            'post_id' => 'required|integer',
            'action' => 'required|in:upvote,downvote,star,save',
        ]);

        $response = Response::where('post_id', $request->post_id)
            ->where('user_id', Auth::id())
            ->where('action', '!=', $request->action)
            ->get();

        foreach ($response as $res) {
            if (in_array($res->action, ['upvote', 'star']) && $request->action == 'downvote') {
                $res->delete();
            } else if (in_array($res->action, ['downvote']) && $request->action == 'upvote') {
                $res->delete();
            }else if (in_array($res->action, ['downvote']) && $request->action == 'star') {
                    $res->delete();
            } else if ($res->action == 'star' && $request->action == 'upvote') {
                continue;
            } else if ($res->action == 'upvote' && $request->action == 'star') {
                $res->delete();
            }
        }

        // Create the response.
        if ($request->action == 'star') {
            Response::create([
                'post_id' => $request->post_id,
                'user_id' => Auth::id(),
                'action' => 'upvote'
            ]);
        }

        Response::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'action' => $request->action
        ]);

        // Redirect the user back to the post page with a success message.
        return redirect()->route('post.show', ['id' => $request->post_id]);
    }
    
    /**
     * Delete the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function destroy(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer',
            'action' => 'required|in:upvote,downvote,star,save',
        ]);

        $response = Response::where('post_id', $request->post_id)
            ->where('user_id', Auth::id())
            ->where('action', $request->action)
            ->first();

        if (!$response) {
            abort(404);
        }

        if ($request->action == 'star') {
            Response::where('post_id', $request->post_id)
                ->where('user_id', Auth::id())
                ->where('action', 'upvote')
                ->first()
                ->delete();
        } else if ($request->action == 'upvote') {
            Response::where('post_id', $request->post_id)
                ->where('user_id', Auth::id())
                ->where('action', 'star')
                ->first()
                ->delete();
        }

        $response->delete();

        return redirect()->back();
    }
}


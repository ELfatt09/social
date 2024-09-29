<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Follow a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request)
    {
        $user = $this->getUser($request->id);

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $this->createFollow($user);

        return redirect()->route('profile.show', ['id' => $user->id]);
    }

    /**
     * Unfollow a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unfollow(Request $request)
    {
        $user = $this->getUser($request->id);

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $this->deleteFollow($user);

        return redirect()->route('profile.show', ['id' => $user->id]);
    }

    /**
     * Get a user by ID.
     *
     * @param  int  $userId
     * @return \App\Models\User
     */
    private function getUser($userId)
    {
        return User::find($userId);
    }

    /**
     * Create a follow record.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function createFollow(User $user)
    {
        Follow::create([
            'follower_id' => Auth::id(),
            'following_id' => $user->id,
        ]);
    }

    /**
     * Delete a follow record.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    private function deleteFollow(User $user)
    {
        Follow::where('follower_id', Auth::id())
            ->where('following_id', $user->id)
            ->delete();
    }
}


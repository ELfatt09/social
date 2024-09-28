<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function show(int $userId)
    {
        $user = User::with('posts')->findOrFail($userId);
        $pageName = $user->name ."'s Profile";

        $posts = $user->posts()->latest()->paginate(10);

        return view('profile.show', compact('user', 'pageName'))
            ->with('posts', $posts);
    }

    /**
     * Show the edit profile form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'))->with(['pageName'=>'Edit Profile']);
    }

    /**
     * Update the profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:600'],
            'pfp' => ['nullable', 'file', 'max:102400'],
        ]);

        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
        ]);

        if ($request->hasFile('pfp')) {
            $pfpUpdate = mediaController::update($request->file('pfp'), 'pfp_id', Auth::id());
            $user->pfp()->associate($pfpUpdate);
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}


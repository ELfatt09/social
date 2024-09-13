<?php

namespace App\Http\Controllers;

use App\Models\Media;
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

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:6'],
            'bio' => ['nullable', 'string', 'max:600'],
            'pfp' => ['nullable', 'file', 'max:102400'],
        ]);

        $user->fill($request->only('name', 'email', 'bio'));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('pfp')) {
            $media = Media::updateOrCreate(
                ['pfp_id' => Auth::id()],
                [
                    'file_type' => $request->file('pfp')->getClientOriginalExtension(),
                    'file_name' => $request->file('pfp')->getClientOriginalName(),
                    'file_path' => $request->file('pfp')->store('uploads', 'public'),
                    'mime_type' => $request->file('pfp')->getMimeType(),
                    'file_size' => $request->file('pfp')->getSize(),
                ]
            );
            $user->pfp()->associate($media);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the user by ID
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $id)->latest()->paginate(10);

        // Return the view with user data
        return view('profile.show', compact('user', 'posts'));
    }
    /**
     * Show the edit profile form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
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

        $this->updateUserInformation($user, $request);

        if ($request->hasFile('pfp')) {
            $media = $this->updateMedia($request);
            $this->associatePfpWithUser($user, $media);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Updates a user's information based on the provided request data.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function updateUserInformation(User $user, Request $request)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->bio = $request->input('bio');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    }

    /**
     * Updates the user's profile picture in the database and on the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Media
     */
    private function updateMedia(Request $request): Media
    {
        $file = $request->file('pfp');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        return Media::updateOrCreate(
            ['pfp_id' => Auth::id()],
            [
                'file_type' => $file->getClientOriginalExtension(),
                'file_name' => $fileName,
                'file_path' => '/storage/' . $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]
        );
    }

    /**
     * Associates the user with the profile picture.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media  $media
     * @return void
     */
    private function associatePfpWithUser(User $user, Media $media)
    {
        $user->pfp()->associate($media);
        $user->save();
    }
}

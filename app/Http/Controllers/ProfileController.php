<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show the edit profile form
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    // Update the profile
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|confirmed|min:6',
            'pfp' => 'nullable|file|max:102400', // Add validation for PFP upload
        ]);

        // Update the user information
        $this->updateUserInformation($user, $request);

        // Handle PFP upload
        if ($request->hasFile('pfp')) {
            $mediaModel = $this->updateMedia($request);
            $this->associatePfpWithUser($user, $mediaModel);
        }

        // Save the changes to the database
        $user->save();

        // Return a success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    private function updateUserInformation(User $user, Request $request)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    }

    private function updateMedia(Request $request)
    {
        $media = $request->file('pfp');
        $fileName = time() . '_' . $media->getClientOriginalName();
        $filePath = $media->storeAs('uploads', $fileName, 'public');

        // Update the media information in the database
        $mediaModel = Media::updateOrCreate(
            ['pfp_id' => Auth::id()],
            [
                'file_type' => $media->getClientOriginalExtension(),
                'file_name' => $fileName,
                'file_path' => '/storage/' . $filePath,
                'mime_type' => $media->getMimeType(),
                'file_size' => $media->getSize(),
            ]
        );

        return $mediaModel;
    }

    private function associatePfpWithUser(User $user, Media $mediaModel)
    {
        // Update the user's PFP relationship
        $user->pfp()->associate($mediaModel);
        $user->save();
    }
}
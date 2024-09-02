<?php
namespace App\Http\Controllers;

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
        ]);

        // Update the user information
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save the changes to the database
        $user->save();

        // Return a success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
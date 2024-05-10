<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }
     public function edit()
    {
        $user = auth()->user();
        return view('profile.ubah', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|string|min:8', // Password dapat kosong atau minimal 8 karakter
        ]);
    
        // Periksa apakah password diisi atau tidak
        if (!empty($request->password)) {
            // Jika password diisi, update dengan password baru
            auth()->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Hash password baru
            ]);
        } else {
            // Jika password tidak diisi, update tanpa mengubah password
            auth()->user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

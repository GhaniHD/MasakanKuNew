<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $disk = config('filesystems.default');

        if ($request->hasFile('profile_picture')) {
            Storage::makeDirectory('public/profile_pictures');
            // Hapus foto lama jika local storage
            if ($user->profile_picture_url && $disk !== 'cloudinary') {
                $oldPath = ltrim(str_replace(url('/storage'), '', $user->profile_picture_url), '/');
                Storage::disk('public')->delete($oldPath);
            }

            if ($disk === 'cloudinary') {
                $path = $request->file('profile_picture')
                    ->store('masakanku/profile_pictures', 'cloudinary');
                $user->profile_picture_url = $path; // Cloudinary sudah return full URL
            } else {
                $path = $request->file('profile_picture')
                    ->store('profile_pictures', 'public');
                $user->profile_picture_url = Storage::url($path);
            }

            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-picture-updated');
    }

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

    public function favorites(): View
    {
        $favorites = Auth::check() ? Auth::user()->favorites : collect();

        return view('profile.favorites', ['favorites' => $favorites]);
    }

    public function index(): View
    {
        return view('profile.index');
    }
}

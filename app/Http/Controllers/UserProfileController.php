<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $iklanCount  = $user->iklan()->count();
        $kritikCount = $user->kritikSaran()->count();

        return view('users.profile.index', compact('user', 'iklanCount', 'kritikCount'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.profile.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $rules = [
        'name'          => ['required', 'string', 'max:255'],
        'email'         => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'no_tlp'        => ['nullable', 'string', 'max:20'],
        'alamat'        => ['nullable', 'string', 'max:255'],
        'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
    ];

    // Tambahkan validasi password kalau field diisi
    if ($request->filled('password')) {
        $rules['current_password'] = ['required', function ($attribute, $value, $fail) use ($user) {
            if (! Hash::check($value, $user->password)) {
                $fail('Password saat ini salah.');
            }
        }];
        $rules['password'] = ['required', 'min:8', 'confirmed'];
    }

    $validated = $request->validate($rules);

    // Update data biasa
    $user->update($request->only(['name', 'email', 'no_tlp', 'alamat']));

    // Update foto kalau ada
    if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $path = $request->file('profile_photo')->store('profiles', 'public');
        $user->update(['profile_photo_path' => $path]);
    }

    // Update password kalau diisi dan valid
    if ($request->filled('password')) {
        $user->update(['password' => Hash::make($request->password)]);
    }

    return redirect()->route('user.profile.index')
        ->with('success', 'Profil berhasil diperbarui!');
}
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's private profile.
     */
    public function index()
    {
        $user = Auth::user();
        $paintings = $user->paintings()->latest()->get();
        return view('profile.index', compact('user', 'paintings'));
    }
    
    /**
     * Display the specified user's public profile.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $paintings = $user->paintings()->latest()->get();
        return view('profile.show', compact('user', 'paintings'));
    }
    
    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user->name = $request->name;
        $user->bio = $request->bio;
        
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Upload new image
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
        
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
    }
    
    /**
     * Show the form for changing the user's password.
     */
    public function changePasswordForm()
    {
        return view('profile.change-password');
    }
    
    /**
     * Change the user's password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Password berhasil diubah');
    }

    /**
     * Show user's private profile
     */
    public function myProfile()
    {
        $user = Auth::user();
        $paintings = $user->paintings()->latest()->get();
        $totalLikes = 0;
        
        foreach ($paintings as $painting) {
            $totalLikes += $painting->likes()->count();
        }
        
        return view('profile.my-profile', compact('user', 'paintings', 'totalLikes'));
    }
    
    /**
     * Show public profile of a user
     */
    public function publicProfile($id)
    {
        $user = User::findOrFail($id);
        $paintings = $user->paintings()->latest()->get();
        $totalLikes = 0;
        
        foreach ($paintings as $painting) {
            $totalLikes += $painting->likes()->count();
        }
        
        return view('profile.public', compact('user', 'paintings', 'totalLikes'));
    }
}

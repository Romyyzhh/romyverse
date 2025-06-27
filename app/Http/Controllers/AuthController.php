<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'bio' => $request->bio,
            ];

            if ($request->hasFile('profile_picture')) {
                // Pastikan direktori ada
                $profilePictureDir = storage_path('app/public/profile_pictures');
                if (!file_exists($profilePictureDir)) {
                    mkdir($profilePictureDir, 0755, true);
                }
                
                // Log untuk debugging
                \Log::info('Uploading profile picture during registration', [
                    'file_exists' => $request->file('profile_picture')->isValid(),
                    'original_name' => $request->file('profile_picture')->getClientOriginalName(),
                    'size' => $request->file('profile_picture')->getSize(),
                    'mime' => $request->file('profile_picture')->getMimeType(),
                    'profile_dir_exists' => file_exists($profilePictureDir),
                    'profile_dir_writable' => is_writable($profilePictureDir)
                ]);
                
                $image = $request->file('profile_picture');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                \Log::info('Storing profile picture', [
                    'path' => 'public/profile_pictures/' . $imageName
                ]);
                
                // Simpan file secara langsung
                $path = $image->storeAs('public/profile_pictures', $imageName);
                
                // Verifikasi file tersimpan
                $fullPath = storage_path('app/' . $path);
                $fileExists = file_exists($fullPath);
                $fileSize = $fileExists ? filesize($fullPath) : 0;
                
                \Log::info('Storage path result', [
                    'path' => $path,
                    'full_path' => $fullPath,
                    'file_exists' => $fileExists,
                    'file_size' => $fileSize
                ]);
                
                if (!$fileExists || $fileSize === 0) {
                    // Coba cara alternatif untuk menyimpan file
                    $image->move(public_path('storage/profile_pictures'), $imageName);
                    
                    $altPath = 'storage/profile_pictures/' . $imageName;
                    $altFullPath = public_path($altPath);
                    
                    \Log::info('Alternative storage result', [
                        'path' => $altPath,
                        'full_path' => $altFullPath,
                        'file_exists' => file_exists($altFullPath),
                        'file_size' => file_exists($altFullPath) ? filesize($altFullPath) : 0
                    ]);
                    
                    $userData['profile_picture'] = 'profile_pictures/' . $imageName;
                } else {
                    $userData['profile_picture'] = 'profile_pictures/' . $imageName;
                }
            }

            $user = User::create($userData);

            Auth::login($user);
            
            \Log::info('User registered successfully', [
                'user_id' => $user->id,
                'profile_picture' => $user->profile_picture
            ]);

            return redirect()->route('paintings.index')
                ->with('success', 'Registration successful! Welcome to Art Gallery.');
                
        } catch (\Exception $e) {
            \Log::error('Error during registration', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Error during registration: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('paintings.index'))
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'bio' => 'nullable|string|max:1000',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        try {
            if ($request->hasFile('profile_picture')) {
                // Pastikan direktori ada
                $profilePictureDir = storage_path('app/public/profile_pictures');
                if (!file_exists($profilePictureDir)) {
                    mkdir($profilePictureDir, 0755, true);
                }
                
                // Log untuk debugging
                \Log::info('Uploading profile picture', [
                    'file_exists' => $request->file('profile_picture')->isValid(),
                    'original_name' => $request->file('profile_picture')->getClientOriginalName(),
                    'size' => $request->file('profile_picture')->getSize(),
                    'mime' => $request->file('profile_picture')->getMimeType(),
                    'profile_dir_exists' => file_exists($profilePictureDir),
                    'profile_dir_writable' => is_writable($profilePictureDir)
                ]);
                
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    $oldPath = 'public/' . $user->profile_picture;
                    \Log::info('Deleting old profile picture', [
                        'path' => $oldPath,
                        'full_path' => storage_path('app/' . $oldPath),
                        'file_exists' => Storage::exists($oldPath)
                    ]);
                    
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                $image = $request->file('profile_picture');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                \Log::info('Storing profile picture', [
                    'path' => 'public/profile_pictures/' . $imageName
                ]);
                
                // Simpan file secara langsung
                $path = $image->storeAs('public/profile_pictures', $imageName);
                
                // Verifikasi file tersimpan
                $fullPath = storage_path('app/' . $path);
                $fileExists = file_exists($fullPath);
                $fileSize = $fileExists ? filesize($fullPath) : 0;
                
                \Log::info('Storage path result', [
                    'path' => $path,
                    'full_path' => $fullPath,
                    'file_exists' => $fileExists,
                    'file_size' => $fileSize
                ]);
                
                if (!$fileExists || $fileSize === 0) {
                    // Coba cara alternatif untuk menyimpan file
                    $image->move(public_path('storage/profile_pictures'), $imageName);
                    
                    $altPath = 'storage/profile_pictures/' . $imageName;
                    $altFullPath = public_path($altPath);
                    
                    \Log::info('Alternative storage result', [
                        'path' => $altPath,
                        'full_path' => $altFullPath,
                        'file_exists' => file_exists($altFullPath),
                        'file_size' => file_exists($altFullPath) ? filesize($altFullPath) : 0
                    ]);
                    
                    $user->profile_picture = 'profile_pictures/' . $imageName;
                } else {
                    $user->profile_picture = 'profile_pictures/' . $imageName;
                }
            }

            $user->save();
            
            \Log::info('Profile updated successfully', [
                'user_id' => $user->id,
                'profile_picture' => $user->profile_picture
            ]);
            
            return redirect()->route('profile')
                ->with('success', 'Profile updated successfully.');
                
        } catch (\Exception $e) {
            \Log::error('Error updating profile', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Error uploading profile picture: ' . $e->getMessage()])
                ->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Hanya admin yang bisa mengakses halaman ini
        // Middleware AdminMiddleware sudah menangani ini

        $totalPaintings = Painting::count();
        $totalUsers = User::count();
        $recentPaintings = Painting::with('user')->latest()->take(5)->get();
        $userWithMostPaintings = User::withCount('paintings')
            ->orderBy('paintings_count', 'desc')
            ->first();

        return view('admin.dashboard', compact(
            'totalPaintings',
            'totalUsers',
            'recentPaintings',
            'userWithMostPaintings'
        ));
    }

    /**
     * Show list of all users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::withCount('paintings')->orderBy('created_at', 'desc')->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show details of a specific user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function showUser(User $user)
    {
        $paintings = $user->paintings()->latest()->get();
        
        return view('admin.users.show', compact('user', 'paintings'));
    }

    /**
     * Delete a user and all their paintings.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(User $user)
    {
        // Cek apakah user yang akan dihapus adalah admin
        if ($user->is_admin) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun admin.');
        }
        
        // Cek apakah user yang akan dihapus adalah user yang sedang login
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }
        
        // Hapus semua lukisan user
        foreach ($user->paintings as $painting) {
            // Hapus file gambar jika ada
            if ($painting->image) {
                $fullPath = storage_path('app/public/' . $painting->image);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
            
            // Hapus lukisan dari database
            $painting->delete();
        }
        
        // Hapus foto profil user jika ada
        if ($user->profile_picture) {
            $fullPath = storage_path('app/public/' . $user->profile_picture);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
        
        // Hapus user dari database
        $userName = $user->name;
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', "Akun user '{$userName}' beserta semua lukisannya berhasil dihapus.");
    }
}

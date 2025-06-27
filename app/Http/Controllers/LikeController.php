<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Painting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like for a painting
     */
    public function toggle(Request $request, Painting $painting)
    {
        $existing = Like::where('user_id', Auth::id())
                        ->where('painting_id', $painting->id)
                        ->first();
        
        if ($existing) {
            // Unlike the painting
            $existing->delete();
            $liked = false;
            $message = 'Lukisan dihapus dari koleksi favorit';
        } else {
            // Like the painting
            Like::create([
                'user_id' => Auth::id(),
                'painting_id' => $painting->id
            ]);
            $liked = true;
            $message = 'Lukisan ditambahkan ke koleksi favorit';
            
            // Create notification for the painting owner (if not liking own painting)
            if ($painting->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $painting->user_id, // To the painting owner
                    'from_user_id' => Auth::id(), // From the liker
                    'painting_id' => $painting->id,
                    'type' => 'like',
                    'message' => Auth::user()->name . ' menyukai lukisan Anda "' . $painting->title . '"'
                ]);
            }
        }
        
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'liked' => $liked,
                'count' => $painting->likes()->count(),
                'message' => $message
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Show user's liked paintings
     */
    public function index()
    {
        $likes = Auth::user()->likes()->with('painting')->latest()->get();
        $paintings = $likes->pluck('painting');
        
        return view('likes.index', compact('paintings'));
    }
}

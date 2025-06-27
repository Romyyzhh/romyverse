<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Painting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment
     */
    public function store(Request $request, Painting $painting)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        
        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'painting_id' => $painting->id
        ]);
        
        $comment->save();
        
        // Create notification for the painting owner (if not commenting on own painting)
        if ($painting->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $painting->user_id, // To the painting owner
                'from_user_id' => Auth::id(), // From the commenter
                'painting_id' => $painting->id,
                'type' => 'comment',
                'message' => Auth::user()->name . ' mengomentari lukisan Anda "' . $painting->title . '"'
            ]);
        }
        
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }
    
    /**
     * Remove the specified comment
     */
    public function destroy(Comment $comment)
    {
        // Only allow the comment owner or admin to delete
        if (Auth::id() === $comment->user_id || Auth::user()->is_admin) {
            $comment->delete();
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
    }
}

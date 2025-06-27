<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->with(['fromUser', 'painting'])->latest()->paginate(15);
        
        // Update all notifications to read
        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        
        return view('notifications.index', compact('notifications'));
    }
    
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        
        $notification->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai telah dibaca');
    }
    
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai telah dibaca');
    }
    
    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }
}

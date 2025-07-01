<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Toggle follow/unfollow a user
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggle(User $user)
    {
        // Prevent following yourself
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengikuti diri sendiri.');
        }
        
        $isFollowing = Auth::user()->isFollowing($user);
        
        if ($isFollowing) {
            // Unfollow
            Auth::user()->following()->detach($user->id);
            $message = 'Anda berhenti mengikuti ' . $user->name;
        } else {
            // Follow
            Auth::user()->following()->attach($user->id);
            $message = 'Anda mulai mengikuti ' . $user->name;
            
            // Create notification
            Notification::create([
                'user_id' => $user->id,
                'from_user_id' => Auth::id(),
                'type' => 'follow',
                'message' => Auth::user()->name . ' mulai mengikuti Anda'
            ]);
        }
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'isFollowing' => !$isFollowing,
                'followerCount' => $user->followers()->count(),
                'message' => $message
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Display followers of a user
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(20);
        
        return view('follows.followers', compact('user', 'followers'));
    }
    
    /**
     * Display users that a user is following
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function following(User $user)
    {
        $following = $user->following()->paginate(20);
        
        return view('follows.following', compact('user', 'following'));
    }
}

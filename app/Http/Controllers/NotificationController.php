<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id)
    {
        $user = Auth::guard('customer')->check() ? Auth::guard('customer')->user() : Auth::user();
        
        if ($user) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        
        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::guard('customer')->check() ? Auth::guard('customer')->user() : Auth::user();
        
        if ($user) {
            $user->unreadNotifications()->update(['read_at' => now()]);
        }
        
        return back();
    }
}

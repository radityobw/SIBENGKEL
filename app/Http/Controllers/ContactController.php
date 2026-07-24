<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\SystemNotification;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function index()
    {
        $page = \App\Models\Page::where('slug', 'contact-us')->first();
        return view('public.contact', compact('page'));
    }

    /**
     * Store the submitted contact message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new SystemNotification(
                'Pesan Baru dari ' . $validated['name'],
                $validated['message'],
                route('admin.messages.index')
            ));
        }

        return back()->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
    
    /**
     * Admin: View all messages
     */
    public function adminIndex()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }
    
    /**
     * Admin: Mark as read
     */
    public function adminMarkAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }
    
    /**
     * Admin: Delete message
     */
    public function adminDestroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}

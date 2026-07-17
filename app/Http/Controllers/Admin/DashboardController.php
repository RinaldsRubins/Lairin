<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'bookings_pending' => Booking::query()->where('status', 'pending')->count(),
            'bookings_today' => Booking::query()->whereDate('date', today())->count(),
            'unread_messages' => ContactMessage::query()->where('is_read', false)->count(),
            'published_projects' => Project::query()->where('is_published', true)->count(),
            'published_posts' => BlogPost::query()->where('is_published', true)->count(),
        ];

        $recentBookings = Booking::query()
            ->with('service')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $recentMessages = ContactMessage::query()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'recentMessages' => $recentMessages,
        ]);
    }
}

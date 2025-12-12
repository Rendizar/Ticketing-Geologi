<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get stats for display
        $stats = [
            'resolved_tickets' => 500, // This would come from database in real app
            'support_hours' => '24/7',
            'expert_count' => 50,
            'satisfaction_rate' => 98
        ];

        // Get active events
        $events = Event::where('is_active', true)
                      ->where('event_date', '>=', now())
                      ->orderBy('event_date')
                      ->take(6)
                      ->get();

        $reviews = Review::latest()->take(12)->get();

        return view('visitor.home', compact('stats', 'events', 'reviews'));
    }
}

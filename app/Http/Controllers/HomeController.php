<?php

namespace App\Http\Controllers;

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

        return view('visitor.home', compact('stats'));
    }
}

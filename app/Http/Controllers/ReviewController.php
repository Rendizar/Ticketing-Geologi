<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thank you! Your review has been submitted.',
                'review' => $review,
            ], 201);
        }

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted.');
    }

    public function index()
    {
        $reviews = Review::latest()->get();
        return view('visitor.home', compact('reviews'));
    }
}


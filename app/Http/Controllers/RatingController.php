<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Booking $booking)
    {
        // Verify that the current user owns this booking
        if (Auth::id() !== $booking->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return view('ratings.create', compact('booking'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'booking_id' => 'required|exists:booking,id',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:1000',
            ]);

            $booking = Booking::findOrFail($request->booking_id);

            if (Auth::id() !== $booking->user_id || !$booking->struk || $booking->struk->payment_status !== 'paid') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if ($booking->rating()->exists()) {
                return response()->json(['error' => 'Rating already exists'], 400);
            }

            $rating = Rating::create([
                'booking_id' => $validatedData['booking_id'],
                'user_id' => Auth::id(),
                'rating' => $validatedData['rating'],
                'review' => $validatedData['review'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rating berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            Log::error('Rating Error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Booking;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Mail\BookingApproved;
use App\Mail\BookingRejected;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();

        // Pagination untuk bookings dengan nama page yang berbeda
        $bookings = $user->bookings()
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'bookings_page');

        // Pagination untuk payments dengan nama page yang berbeda
        $payments = $user->payments()
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'payments_page');

        // Pagination untuk messages yang belum dibaca
        $messages = $user->receivedMessages()
            ->where('read_at', null)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'messages_page');

        return view('dashboard', compact('user', 'bookings', 'payments', 'messages'));
    }
    // Menampilkan daftar booking untuk user
    public function userBookings()
    {
        $jasa = Jasa::all();
        $bookings = Booking::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(5);
        return view('bookings.user_bookings', compact('bookings', 'jasa'));
    }

    // Menampilkan daftar booking untuk admin
    public function adminBookings()
    {
        // Calculate statistics
        $totalProfit = Booking::whereHas('struk', function ($query) {
            $query->where('payment_status', 'paid');
        })->with('struk')->get()->sum(function ($booking) {
            return $booking->struk->total_amount;
        });

        $paidOrdersCount = Booking::whereHas('struk', function ($query) {
            $query->where('payment_status', 'paid');
        })->count();

        $pendingPayments = Booking::whereHas('struk', function ($query) {
            $query->where('payment_status', 'unpaid');
        })->with('struk')->get()->sum(function ($booking) {
            return $booking->struk->total_amount;
        });

        $pendingOrdersCount = Booking::whereHas('struk', function ($query) {
            $query->where('payment_status', 'unpaid');
        })->count();

        $messages = Message::with('sender')
            ->where('read_at', null)
            ->whereHas('sender', function ($query) {
                $query->where('is_admin', false);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $jasas = Jasa::all();

        return view('bookings.admin_bookings', compact(
            'totalProfit',
            'paidOrdersCount',
            'pendingPayments',
            'pendingOrdersCount',
            'messages',
            'jasas'
        ));
    }

    public function getDetail($id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if (!Auth::user()->is_admin && Auth::id() !== $booking->user_id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        return view('bookings.detail', compact('booking'));
    }

    public function getDetailUser($id)
    {
        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->user_id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        return view('bookings.detailuser', compact('booking'));
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Ensure only the booking owner or admin can delete
            if (!Auth::user()->is_admin && Auth::id() !== $booking->user_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Akses ditolak'
                ], 403);
            }

            // Allow deletion for pending and rejected bookings
            if (!in_array($booking->status, ['pending', 'rejected'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Booking tidak dapat dihapus'
                ], 400);
            }

            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            \Log::error('Booking Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat menghapus booking'
            ], 500);
        }
    }

    // Proses persetujuan booking oleh admin
    public function approve($id)
    {
        // Pastikan hanya admin yang bisa menyetujui
        if (!Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $booking = Booking::findOrFail($id);
        $booking->status = 'approved';
        $booking->save();

        // Kirim email notifikasi
        try {
            Mail::to($booking->user->email)->send(new BookingApproved($booking));
        } catch (\Exception $e) {
            \Log::error('Detail Email Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            // Tetap lanjutkan proses meski email gagal
        }

        return redirect()->route('bookings.admin')->with('success', 'Booking berhasil disetujui');
    }

    public function showRejectModal($id)
    {
        $booking = Booking::findOrFail($id);

        // Pastikan hanya admin yang bisa mengakses
        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        return view('bookings.reject', compact('booking'));
    }

    // Proses penolakan booking oleh admin

    public function reject(Request $request, $id)
    {
        // Pastikan hanya admin yang bisa menolak
        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $request->validate([
            'pesan' => 'required|string|max:1000'
        ]);

        try {
            $booking = Booking::findOrFail($id);
            $booking->status = 'rejected';
            $booking->pesan = $request->pesan;
            $booking->save();

            // Kirim email notifikasi
            try {
                Mail::to($booking->user->email)->send(new BookingRejected($booking));
            } catch (\Exception $e) {
                \Log::error('Booking Rejection Email Error: ' . $e->getMessage());
                // Tetap lanjutkan proses meski email gagal
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            \Log::error('Booking Reject Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat menolak booking'
            ], 500);
        }
    }

}
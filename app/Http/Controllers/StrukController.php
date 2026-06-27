<?php

namespace App\Http\Controllers;

use App\Models\Struk;
use App\Mail\StrukCek;
use App\Mail\StrukPaid;
use App\Models\Booking;
use App\Mail\StrukCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StrukController extends Controller
{

    public function show(Booking $booking)
    {
        
        $struk = $booking->struk()->with('items')->firstOrFail();
        return view('struks.detail', compact('struk'));
    }

    public function showuser(Booking $booking)
    {
        $struk = $booking->struk()->with('items')->firstOrFail();
        return view('struks.detailuser', compact('struk'));
    }

    public function update(Request $request, Struk $struk)
    {
        if ($struk->payment_status === 'paid') {
            return back()->with('error', 'Struk yang sudah dibayar tidak dapat diubah');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.price' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,unpaid,cek',
            'description' => 'required|string',
            'is_garansi' => 'nullable|string',
            'garansi_date' => 'required_if:is_garansi,on|date|nullable',
            'garansi_desc' => 'required_if:is_garansi,on|string|nullable',
        ]);

        try {
            DB::beginTransaction();

            $struk->update([
                'payment_status' => $validated['payment_status'],
                'total_amount' => collect($validated['items'])->sum('price'),
                'description' => $validated['description'],
                'is_garansi' => $request->has('is_garansi'),
                'garansi_date' => $request->has('is_garansi') ? $request->garansi_date : null,
                'garansi_desc' => $request->has('is_garansi') ? $request->garansi_desc : null,
            ]);

            $struk->items()->delete();
            foreach ($validated['items'] as $item) {
                $struk->items()->create([
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'price' => $item['price'],
                ]);
            }

            $booking = Booking::with('user')->findOrFail($struk->booking_id);

            if ($validated['payment_status'] === 'paid') {
                Mail::to($booking->user->email)->send(new StrukPaid($struk, $booking));
            } elseif ($validated['payment_status'] === 'cek') {
                Mail::to($booking->user->email)->send(new StrukCek($struk, $booking));
            }

            DB::commit();
            return redirect()->route('bookings.admin')
                ->with('success', 'Struk berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating struk: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui struk');
        }
    }
}
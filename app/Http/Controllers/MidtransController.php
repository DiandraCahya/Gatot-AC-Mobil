<?php

namespace App\Http\Controllers;

use App\Models\Struk;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getPaymentToken(Struk $struk)
    {
        try {
            Log::info('Payment request for struk:', ['struk_id' => $struk->id]);
            $items = [];
            foreach ($struk->items as $item) {
                $items[] = [
                    'id' => 'ITEM-' . $item->id,
                    'price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'name' => $item->name
                ];
            }

            $transactionDetails = [
                'order_id' => 'STRUK-' . $struk->id . '-' . time(),
                'gross_amount' => $struk->total_amount,
            ];

            $customerDetails = [
                'first_name' => $struk->booking->user->name,
                'email' => $struk->booking->user->email,
            ];

            $params = [
                'transaction_details' => $transactionDetails,
                'item_details' => $items,
                'customer_details' => $customerDetails
            ];

            // Mendapatkan token transaksi dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Update struk dengan snap token
            $struk->update([
                'snap_token' => $snapToken,
                'order_id' => $transactionDetails['order_id']
            ]);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan dalam memproses pembayaran'
            ], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $notification = json_decode($request->getContent(), true);
            $orderId = $notification['order_id'];
            $transactionStatus = $notification['transaction_status'];
            $fraudStatus = $notification['fraud_status'];

            $struk = Struk::where('order_id', $orderId)->firstOrFail();

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $struk->update(['payment_status' => 'paid']);
                }
            } else if ($transactionStatus == 'settlement') {
                $struk->update(['payment_status' => 'paid']);
            } else if (
                $transactionStatus == 'cancel' ||
                $transactionStatus == 'deny' ||
                $transactionStatus == 'expire'
            ) {
                $struk->update(['payment_status' => 'unpaid']);
            } else if ($transactionStatus == 'pending') {
                $struk->update(['payment_status' => 'unpaid']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
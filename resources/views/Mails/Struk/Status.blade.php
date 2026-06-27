<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            color: #e2e8f0;
        }

        .wrapper {
            padding: 20px;
            background-color: #f3f4f6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1a1c2a;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            padding: 40px 20px;
            text-align: center;
            background: {{ $status === 'paid' ? 'linear-gradient(135deg, #047857 0%, #10b981 100%)' : 'linear-gradient(135deg, #1e40af 0%, #3b82f6 100%)' }};
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            background-color: {{ $status === 'paid' ? '#059669' : '#1e40af' }};
        }

        .content {
            padding: 32px 24px;
        }

        .message {
            font-size: 16px;
            margin-bottom: 24px;
            color: #e2e8f0;
        }

        .details-box {
            background-color: #252837;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            border-left: 4px solid {{ $status === 'paid' ? '#059669' : '#1e40af' }};
        }

        .detail-row {
            border-bottom: 1px solid #363a4f;
            padding: 12px 0;
            display: flex;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #60a5fa;
            font-weight: 600;
            width: 140px;
        }

        .detail-value {
            color: #f1f5f9;
            flex: 1;
        }

        /* Button styles */
        .button-container {
            text-align: center;
            margin: 32px 0;
            color: inherit;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .footer {
            background-color: #252837;
            padding: 24px;
            text-align: center;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Status Struk</h1>
                <div class="status-badge">
                    Status: {{ $statusText }}
                </div>
            </div>

            <div class="content">
                <p class="message">Halo {{ $booking->user->name }},</p>

                @if ($status === 'paid')
                    <p class="message">Pembayaran Anda telah dikonfirmasi. Berikut detail struk:</p>
                @else
                    <p class="message">Pengecekan telah selesai. Berikut detail struk:</p>
                @endif

                <div class="details-box">
                    <div class="detail-row">
                        <span class="detail-label">Nomor Booking</span>
                        <span class="detail-value">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Pembayaran</span>
                        <span class="detail-value">Rp {{ number_format($struk->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">{{ $statusText }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Deskripsi</span>
                        <span class="detail-value">{{ $struk->description }}</span>
                    </div>
                </div>

                @if ($struk->is_garansi)
                    <div class="details-box">
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Garansi</span>
                            <span
                                class="detail-value">{{ \Carbon\Carbon::parse($struk->garansi_date)->format('d F Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Deskripsi Garansi</span>
                            <span class="detail-value">{{ $struk->garansi_desc }}</span>
                        </div>
                    </div>
                @endif

                <!-- Action Button -->
                <div class="button-container">
                    <a href="{{ route('bookings.user') }}" class="button">
                        Lihat Struk 
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>Terima kasih telah menggunakan layanan kami.</p>
                <p>Email ini dibuat secara otomatis, mohon tidak membalas email ini.</p>
            </div>
        </div>
    </div>
</body>

</html>

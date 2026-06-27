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
            background: linear-gradient(135deg, #7928ca 0%, #ff0080 100%);
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
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
            border-left: 4px solid #ff0080;
        }

        .details-box h3 {
            color: #7928ca;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 20px 0;
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
            color: #ff0080;
            font-weight: 600;
            width: 140px;
        }

        .detail-value {
            color: #f1f5f9;
            flex: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            background-color: #7928ca;
            color: white;
        }

        .status-paid {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        }

        .status-unpaid {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        }

        .status-cek {
            background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
        }

        .warranty-info {
            background-color: #252837;
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
            border-left: 4px solid #7928ca;
        }

        .warranty-info h3 {
            color: #7928ca;
            margin-top: 0;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #252837;
            padding: 24px;
            text-align: center;
            margin-top: 32px;
        }

        .footer p {
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .footer p:last-child {
            color: #64748b;
            font-size: 14px;
            margin: 0;
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

        @media only screen and (max-width: 600px) {
            .wrapper {
                padding: 10px;
            }

            .container {
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Struk Pembayaran</h1>
                <div class="status-badge status-{{ $struk->payment_status }}">
                    {{ ucfirst($struk->payment_status) }}
                </div>
            </div>

            <div class="content">
                <p class="message">Halo {{ $booking->user->name }},</p>
                <p class="message">Struk pembayaran Anda telah dibuat dengan detail sebagai berikut:</p>

                <div class="details-box">
                    <h3>Detail Pembayaran</h3>
                    <div class="detail-row">
                        <span class="detail-label">Nomor Booking</span>
                        <span class="detail-value">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Pembayaran</span>
                        <span class="detail-value">Rp {{ number_format($struk->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Deskripsi</span>
                        <span class="detail-value">{{ $struk->description }}</span>
                    </div>
                </div>

                @if ($struk->is_garansi)
                    <div class="warranty-info">
                        <h3>Informasi Garansi</h3>
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

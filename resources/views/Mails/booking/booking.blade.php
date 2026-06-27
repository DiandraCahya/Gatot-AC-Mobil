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
            background-color: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            padding: 40px 20px;
            text-align: center;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
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
            background-color: #334155;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .details-box h3 {
            color: #60a5fa;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }

        .detail-row {
            border-bottom: 1px solid #475569;
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

        .button-container {
            text-align: center;
            margin: 32px 0;
        }

        .button {
            display: inline-block;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .footer {
            background-color: #334155;
            padding: 24px;
            text-align: center;
        }

        .footer p {
            color: #94a3b8;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>{{ $action === 'created' ? 'Booking Baru' : 'Booking Diperbarui' }}</h1>
            </div>

            <div class="content">
                <p class="message">
                    {{ $action === 'created' ? 'Booking baru telah dibuat' : 'Booking telah diperbarui' }} oleh {{ $booking->nama }}.
                    Silakan tinjau detail booking berikut:
                </p>

                <div class="details-box">
                    <h3>Detail Booking</h3>
                    <div class="detail-row">
                        <span class="detail-label">ID Booking:</span>
                        <span class="detail-value">#{{ $booking->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Customer:</span>
                        <span class="detail-value">{{ $booking->nama }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jenis Layanan:</span>
                        <span class="detail-value">{{ $booking->jenis }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jam:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Mobil:</span>
                        <span class="detail-value">{{ $booking->mobil }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Lokasi:</span>
                        <span class="detail-value">{{ $booking->tempat ? 'Di Tempat' : 'Di Bengkel' }}</span>
                    </div>
                    @if($booking->keterangan)
                    <div class="detail-row">
                        <span class="detail-label">Keterangan:</span>
                        <span class="detail-value">{{ $booking->keterangan }}</span>
                    </div>
                    @endif
                </div>

                <div class="button-container">
                    <a href="{{ route('bookings.admin', $booking->id) }}" class="button">
                        Tinjau Booking
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>Email ini dibuat secara otomatis untuk pemberitahuan booking.</p>
            </div>
        </div>
    </div>
</body>
</html>
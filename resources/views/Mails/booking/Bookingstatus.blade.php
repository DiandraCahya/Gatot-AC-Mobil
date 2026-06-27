<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        /* Reset and base styles */
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

        /* Container styles */
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

        /* Header styles */
        .header {
            padding: 40px 20px;
            text-align: center;
        }

        .header-approved {
            background: linear-gradient(135deg, #047857 0%, #10b981 100%);
        }

        .header-rejected {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .status-badge {
            display: inline-block;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
        }

        .status-badge-approved {
            background-color: #059669;
        }

        .status-badge-rejected {
            background-color: #dc2626;
        }

        /* Content styles */
        .content {
            padding: 32px 24px;
        }

        .message {
            font-size: 16px;
            margin-bottom: 24px;
            color: #e2e8f0;
        }

        /* Alert box styles */
        .alert-box {
            background-color: #334155;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 32px;
            color: white;
        }

        .alert-box-approved {
            border-left: 4px solid #059669;
        }

        .alert-box-rejected {
            border-left: 4px solid #dc2626;
        }

        /* Details box styles */
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

        /* Additional info box styles */
        .info-box {
            background-color: #334155;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .info-box h3 {
            color: #60a5fa;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }

        .info-section {
            margin-bottom: 16px;
            color: white;
        }

        .info-section:last-child {
            margin-bottom: 0;
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

        .button-approved {
            background: linear-gradient(135deg, #047857 0%, #10b981 100%);
        }

        .button-rejected {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        /* Footer styles */
        .footer {
            background-color: #334155;
            padding: 24px;
            text-align: center;
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
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header {{ $booking->status === 'approved' ? 'header-approved' : 'header-rejected' }}">
                <h1>Booking {{ $booking->status === 'approved' ? 'Disetujui' : 'Ditolak' }}</h1>
                <div
                    class="status-badge {{ $booking->status === 'approved' ? 'status-badge-approved' : 'status-badge-rejected' }}">
                    Status: {{ $booking->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <p class="message">Halo {{ $booking->user->name }},</p>
                @if ($booking->status === 'approved')
                    <p class="message">Selamat! Booking Anda telah disetujui. Berikut detail bookingnya:</p>
                    <div class="alert-box alert-box-approved">
                        <p>Silakan datang sesuai jadwal yang telah ditentukan. Jika ada perubahan, harap hubungi kami
                            segera.</p>
                    </div>
                @else
                    <p class="message">Mohon maaf, booking Anda tidak dapat disetujui. Berikut detail dan alasan
                        penolakannya:</p>
                    <div class="alert-box alert-box-rejected">
                        <h3 style="color: #60a5fa; margin-bottom: 12px;">Alasan Penolakan:</h3>
                        <p>{{ $booking->pesan }}</p>
                    </div>
                @endif

                <!-- Booking Details -->
                <div class="details-box">
                    <h3>Detail Booking</h3>
                    <div class="detail-row">
                        <span class="detail-label">ID Booking:</span>
                        <span class="detail-value">#{{ $booking->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jenis Layanan:</span>
                        <span class="detail-value">{{ $booking->jenis }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal:</span>
                        <span
                            class="detail-value">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</span>
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
                        <span class="detail-value">{{ $booking->tempat ? {{ $booking->tempat }} : 'Di Bengkel' }}</span>
                    </div>
                    @if ($booking->keterangan)
                        <div class="detail-row">
                            <span class="detail-label">Keterangan:</span>
                            <span class="detail-value">{{ $booking->keterangan }}</span>
                        </div>
                    @endif
                </div>

                @if ($booking->status === 'approved')
                    <!-- Location & Contact Info (only for approved bookings) -->
                    <div class="info-box">
                        <h3>Informasi Tambahan</h3>
                        <div class="info-section">
                            <p><strong style="color: #60a5fa;">Alamat Bengkel:</strong></p>
                            <p>Jl. Simo Sidomulyo No. 91, Surabaya</p>
                        </div>
                        <div class="info-section">
                            <p><strong style="color: #60a5fa;">Kontak:</strong></p>
                            <p>WA: 0892-3563-3749</p>
                        </div>
                    </div>
                @endif

                <!-- Action Button -->
                <div class="button-container">
                    <a href="{{ route('bookings.user')}}"
                        class="button {{ $booking->status === 'approved' ? 'button-approved' : 'button-rejected' }}">
                        {{ $booking->status === 'approved' ? 'Lihat Daftar Booking' : 'Buat Booking Baru' }}
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>{{ $booking->status === 'approved' ? 'Terima kasih telah menggunakan layanan kami.' : 'Silakan mencoba melakukan booking kembali dengan menyesuaikan permintaan Anda.' }}
                </p>
                <p>Email ini dibuat secara otomatis, mohon tidak membalas email ini.</p>
            </div>
        </div>
    </div>
</body>

</html>

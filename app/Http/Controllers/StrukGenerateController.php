<?php

namespace App\Http\Controllers;

use App\Models\Struk;
use TCPDF;

class StrukGenerateController extends Controller
{
    public function generate(Struk $struk)
    {
        // Create new PDF document
        $pdf = new TCPDF('P', 'mm', array(80, 200), true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('Gatot AC Mobil');
        $pdf->SetAuthor('Gatot AC Mobil');
        $pdf->SetTitle('Gatot AC Mobil #' . $struk->id);

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(true, 5);

        // Add a page
        $pdf->AddPage();

        // Set background color to white
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F');

        // Set text color to black
        $pdf->SetTextColor(0, 0, 0);

        // Set font
        $pdf->SetFont('courier', '', 8);

        // Build the receipt content with enhanced separators
        $html = '
        <div style="text-align: center; line-height: 1.5; background-color: #ffffff; color: #000000;">
            <!-- Header Section with double border -->
            <div style="border-bottom: 3px double #000000; padding-bottom: 10px; margin-bottom: 10px;">
                <span style="font-size: 12pt; font-weight: bold; color: #000000;">GATOT AC MOBIL</span><br>
                <span style="font-size: 9pt; color: #000000;">Specialist Air Conditioning Mobil</span><br>
                <span style="font-size: 8pt; color: #000000;">(088235633749)</span><br>
                <span style="font-size: 8pt; color: #000000;">www.gatotacmobil.my.id</span>
            </div>

            <!-- Customer Info Section -->
            <div style="border-bottom: 1px solid #000000; padding: 5px 0; margin-bottom: 10px;">
                <table style="width: 100%; font-size: 8pt; color: #000000;">
                    <tr>
                        <td style="padding: 2px;">User:</td>
                        <td style="text-align: right; padding: 2px;"><strong>' . $struk->booking->name . '</strong></td>
                    </tr>
                </table>
            </div>

            <!-- Transaction Info Section -->
            <div style="border: 1px dashed #000000; padding: 5px; margin: 10px 0; background-color: #f9f9f9;">
                <table style="width: 100%; font-size: 8pt; color: #000000;">
                    <tr>
                        <td><strong>No: ' . str_pad($struk->id, 7, '0', STR_PAD_LEFT) . '</strong></td>
                        <td style="text-align: right;">' . $struk->created_at->format('d M y H:i:s') . '</td>
                    </tr>
                </table>
            </div>

            <!-- Items Section -->
            <div style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; margin: 10px 0; padding: 10px 0; color: #000000;">
                <table style="width: 100%; font-size: 8pt; line-height: 1.5;">
                    <!-- Header Row -->
                    <tr style="border-bottom: 1px dashed #000000;">
                        <td style="width: 10%; padding: 3px;">Qty</td>
                        <td style="width: 60%; padding: 3px;">Item</td>
                        <td style="width: 30%; text-align: right; padding: 3px;">Harga</td>
                    </tr>';

        // Add items
        foreach ($struk->items as $item) {
            $html .= '
                    <tr style="color: #000000;">
                        <td style="width: 10%; padding: 3px; vertical-align: top;">' . $item->quantity . '</td>
                        <td style="width: 60%; padding: 3px; vertical-align: top;">' . $item->name . '</td>
                        <td style="width: 30%; text-align: right; padding: 3px; vertical-align: top;">Rp ' . number_format($item->unit_price, 0, ',', '.') . '</td>
                    </tr>';
        }

        $html .= '
                </table>
            </div>

            <!-- Total Section with highlighted background -->
            <div style="border: 2px solid #000000; padding: 5px; margin: 10px 0; background-color: #f5f5f5;">
                <table style="width: 100%; font-size: 9pt;">
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td style="text-align: right;"><strong>Rp ' . number_format($struk->total_amount, 0, ',', '.') . '</strong></td>
                    </tr>
                </table>
            </div>';

        // Add description if exists
        if ($struk->description) {
            $html .= '
            <div style="border: 1px solid #000000; margin: 10px 0; padding: 10px; text-align: left; color: #000000; background-color: #f9f9f9;">
                <strong style="font-size: 9pt; border-bottom: 1px solid #000000; display: block; padding-bottom: 5px;">Deskripsi:</strong>
                <div style="font-size: 8pt; margin-top: 5px; line-height: 1.4;">
                    ' . nl2br($struk->description) . '
                </div>
            </div>';
        }

        // Add warranty information if exists
        if ($struk->is_garansi) {
            $html .= '
            <div style="border: 1px solid #000000; margin: 10px 0; padding: 10px; text-align: left; color: #000000; background-color: #f9f9f9;">
                <strong style="font-size: 9pt; border-bottom: 1px solid #000000; display: block; padding-bottom: 5px;">Informasi Garansi:</strong>
                <div style="font-size: 8pt; margin-top: 5px; line-height: 1.4;">
                    <strong>Berlaku sampai:</strong> ' . date('d M Y', strtotime($struk->garansi_date)) . '<br>
                    <strong>Ketentuan:</strong><br>' . $struk->garansi_desc . '
                </div>
            </div>';
        }

        // Enhanced footer with border
        $html .= '
            <div style="border-top: 3px double #000000; margin-top: 10px; padding-top: 10px; text-align: center; color: #000000;">
                <p style="font-size: 8pt; margin: 5px 0;">Terima kasih atas kepercayaan Anda</p>
                <p style="font-size: 8pt; margin: 5px 0;">' . date('d/m/Y H:i:s') . '</p>
                <p style="font-size: 7pt; margin: 5px 0; font-style: italic;">Simpan struk ini sebagai bukti pembayaran yang sah</p>
            </div>
        </div>';

        // Write HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        return $pdf->Output('struk_' . $struk->booking->nama . '.pdf', 'D');
    }
}
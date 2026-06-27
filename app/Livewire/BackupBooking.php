<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Struk;
use App\Models\Rating;
use App\Models\Booking;
use Livewire\Component;
use App\Models\StrukItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BackupBooking extends Component
{
    public $selectedMonth;
    public $selectedYear;
    public $months = [];
    public $years = [];
    public $isProcessing = false;
    public $result = '';
    public $errorMessage = '';
    public $downloadUrl = '';

    public function mount()
    {
        $this->months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $currentYear = date('Y');
        for ($i = 0; $i <= 5; $i++) {
            $year = $currentYear - $i;
            $this->years[$year] = $year;
        }

        $this->selectedMonth = date('n');
        $this->selectedYear = $currentYear;
    }

    public function backup()
    {
        $this->validate([
            'selectedMonth' => 'required|numeric|min:1|max:12',
            'selectedYear' => 'required|numeric|min:2000|max:' . date('Y'),
        ]);
    
        $this->isProcessing = true;
        $this->errorMessage = '';
        $this->result = '';
        $this->downloadUrl = '';
    
        try {
            DB::beginTransaction();
    
            $startDate = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($this->selectedYear, $this->selectedMonth, 1)->endOfMonth();
    
            $periodText = $this->months[$this->selectedMonth] . ' ' . $this->selectedYear;
    
            $bookings = Booking::whereBetween('tanggal', [$startDate, $endDate])
                ->whereHas('struk', function ($query) {
                    $query->where('payment_status', 'paid');
                })
                ->with(['user', 'struk.items', 'rating'])
                ->get();
    
            if ($bookings->isEmpty()) {
                $this->result = "Tidak ada data booking dengan struk yang terbayar untuk {$periodText}";
                $this->isProcessing = false;
                return;
            }
    
            $bookingIds = $bookings->pluck('id')->toArray();
    
            $struks = Struk::whereIn('booking_id', $bookingIds)
                ->where('payment_status', 'paid')
                ->with('items')
                ->get();
    
            $strukItems = StrukItem::whereIn('struk_id', $struks->pluck('id')->toArray())
                ->get();
    
            $ratings = Rating::whereIn('booking_id', $bookingIds)->get();
    
            // Generate Excel file and save it to storage
            $excelFileName = "backup_booking_paid_{$this->selectedYear}_{$this->selectedMonth}.xlsx";
            $this->createExcelBackup($bookings, $struks, $strukItems, $ratings, $periodText, $excelFileName);
    
            // Save JSON backup
            $backupData = [
                'bookings' => $bookings->toArray(),
                'struks' => $struks->toArray(),
                'strukItems' => $strukItems->toArray(),
                'ratings' => $ratings->toArray(),
                'backup_date' => now()->toDateTimeString(),
                'period' => $periodText
            ];
    
            $jsonFileName = "backup_booking_paid_{$this->selectedYear}_{$this->selectedMonth}.json";
            Storage::disk('local')->put("backups/{$jsonFileName}", json_encode($backupData, JSON_PRETTY_PRINT));
    
            // Update database records
            Rating::whereIn('booking_id', $bookingIds)->update(['booking_id' => null]);
            StrukItem::whereIn('struk_id', $struks->pluck('id')->toArray())->delete();
            Struk::whereIn('booking_id', $bookingIds)->delete();
            $deletedCount = Booking::whereIn('id', $bookingIds)->delete();
    
            DB::commit();
    
            $this->result = "Backup dan penghapusan berhasil. {$deletedCount} data booking beserta struk yang sudah terbayar terkait telah dibackup dan dihapus. Rating tetap disimpan dengan booking_id nullified.";
            
            // Just store the filename, not the full URL
            $this->downloadUrl = $excelFileName;
            
            // For Livewire 3
            $this->dispatch('showDownloadConfirmation', filename: $excelFileName);
            
            // Alternative for Livewire 2
            // $this->dispatchBrowserEvent('showDownloadConfirmation', ['filename' => $excelFileName]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = "Error: " . $e->getMessage();
        }
    
        $this->isProcessing = false;
    }

    private function createExcelBackup($bookings, $struks, $strukItems, $ratings, $periodText)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Define reusable styles
        $titleStyle = [
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '000080']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E6F2FF']
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '0070C0']
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
    
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
    
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'BFBFBF']
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP
            ]
        ];
    
        $currencyStyle = [
            'numberFormat' => [
                'formatCode' => '_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)'
            ]
        ];
    
        $alternateRowStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F2F2F2']
            ]
        ];
    
        // BOOKINGS SHEET
        $sheet->setCellValue('A1', 'Gatot AC Mobil - Data Booking ' . $periodText);
        $sheet->mergeCells('A1:K1');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->applyFromArray($titleStyle);
    
        // Add company logo description
        $sheet->setCellValue('A2', 'Laporan Backup dan Penghapusan Data');
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
        $sheet->setTitle('Bookings');
    
        // Set header with improved styling
        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'User');
        $sheet->setCellValue('C3', 'Nama');
        $sheet->setCellValue('D3', 'Jenis');
        $sheet->setCellValue('E3', 'Tanggal');
        $sheet->setCellValue('F3', 'Jam');
        $sheet->setCellValue('G3', 'Mobil');
        $sheet->setCellValue('H3', 'Tempat');
        $sheet->setCellValue('I3', 'Status');
        $sheet->setCellValue('J3', 'Detail Struk');
        $sheet->setCellValue('K3', 'Item Struk');
    
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getStyle('A3:K3')->applyFromArray($headerStyle);
    
        $row = 4;
        foreach ($bookings as $booking) {
            // Get associated struk
            $struk = $booking->struk;
            
            // Skip if struk is not found or not paid (additional safeguard)
            if (!$struk || $struk->payment_status !== 'paid') {
                continue;
            }
            
            // Generate struk details
            $strukDetail = "ID: {$struk->id}\n" .
                           "Total: Rp " . number_format($struk->total_amount, 0, ',', '.') . "\n" .
                           "Garansi: " . ($struk->is_garansi ? "Ya" : "Tidak");
                           
            if ($struk->garansi_date) {
                $strukDetail .= "\nTgl Garansi: " . Carbon::parse($struk->garansi_date)->format('d/m/Y');
            }
            
            if ($struk->description) {
                $strukDetail .= "\nKet: {$struk->description}";
            }
            
            // Generate items list
            $itemsList = "";
            if ($booking->struk && $booking->struk->items) {
                foreach ($booking->struk->items as $index => $item) {
                    $itemsList .= ($index + 1) . ". {$item->name}\n" .
                                  "   {$item->quantity} × Rp " . number_format($item->unit_price, 0, ',', '.') . 
                                  " = Rp " . number_format($item->price, 0, ',', '.') . "\n";
                }
            }
            
            $sheet->setCellValue('A' . $row, $booking->id);
            $sheet->setCellValue('B' . $row, $booking->user ? $booking->user->name : '-');
            $sheet->setCellValue('C' . $row, $booking->nama ?? '-');
            $sheet->setCellValue('D' . $row, $booking->jenis ?? '-');
            $sheet->setCellValue('E' . $row, $booking->tanggal ? Carbon::parse($booking->tanggal)->format('d/m/Y') : '-');
            $sheet->setCellValue('F' . $row, $booking->jam ?? '-');
            $sheet->setCellValue('G' . $row, $booking->mobil ?? '-');
            $sheet->setCellValue('H' . $row, $booking->tempat ?? '-');
            $sheet->setCellValue('I' . $row, $booking->status ?? '-');
            $sheet->setCellValue('J' . $row, $strukDetail);
            $sheet->setCellValue('K' . $row, $itemsList);
            
            // Apply alternating row colors
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray($alternateRowStyle);
            }
            
            $row++;
        }
    
        // Style the data
        $dataRange = 'A4:K' . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray($dataStyle);
        
        // Set wrap text for detail columns
        $sheet->getStyle("J4:K" . ($row - 1))->getAlignment()->setWrapText(true);
    
        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set fixed width for detail columns
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(50);
    
        // Add data summary
        $summaryRow = $row + 1;
        $sheet->setCellValue('A' . $summaryRow, 'Total Data: ' . ($row - 4));
        $sheet->mergeCells('A' . $summaryRow . ':K' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $summaryRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    
        // Add STRUKS SHEET
        $spreadsheet->createSheet();
        $strukSheet = $spreadsheet->setActiveSheetIndex(1);
        $strukSheet->setTitle('Struks');
    
        // Set headers for struk data
        $strukSheet->setCellValue('A1', 'Gatot AC Mobil - Data Struk ' . $periodText);
        $strukSheet->mergeCells('A1:H1');
        $strukSheet->getRowDimension(1)->setRowHeight(30);
        $strukSheet->getStyle('A1')->applyFromArray($titleStyle);
    
        $strukSheet->setCellValue('A3', 'ID');
        $strukSheet->setCellValue('B3', 'Booking ID');
        $strukSheet->setCellValue('C3', 'Status Pembayaran');
        $strukSheet->setCellValue('D3', 'Total');
        $strukSheet->setCellValue('E3', 'Deskripsi');
        $strukSheet->setCellValue('F3', 'Garansi');
        $strukSheet->setCellValue('G3', 'Tgl Garansi');
        $strukSheet->setCellValue('H3', 'Order ID');
    
        $strukSheet->getRowDimension(3)->setRowHeight(20);
        $strukSheet->getStyle('A3:H3')->applyFromArray($headerStyle);
    
        // Add struk data
        $row = 4;
        foreach ($struks as $struk) {
            $strukSheet->setCellValue('A' . $row, $struk->id);
            $strukSheet->setCellValue('B' . $row, $struk->booking_id);
            $strukSheet->setCellValue('C' . $row, $struk->payment_status ?? '-');
            $strukSheet->setCellValue('D' . $row, $struk->total_amount ?? 0);
            $strukSheet->setCellValue('E' . $row, $struk->description ?? '-');
            $strukSheet->setCellValue('F' . $row, $struk->is_garansi ? 'Ya' : 'Tidak');
            $strukSheet->setCellValue('G' . $row, $struk->garansi_date ? Carbon::parse($struk->garansi_date)->format('d/m/Y') : '-');
            $strukSheet->setCellValue('H' . $row, $struk->order_id ?? '-');
            
            // Apply alternating row colors
            if ($row % 2 == 0) {
                $strukSheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($alternateRowStyle);
            }
            
            $row++;
        }
    
        // Style struk data
        $dataRange = 'A4:H' . ($row - 1);
        $strukSheet->getStyle($dataRange)->applyFromArray($dataStyle);
    
        // Format total column
        $strukSheet->getStyle('D4:D' . ($row - 1))->applyFromArray($currencyStyle);
        $strukSheet->getStyle('D4:D' . ($row - 1))->getNumberFormat()->setFormatCode('Rp #,##0');
    
        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $strukSheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Add total summary
        $summaryRow = $row + 1;
        $strukSheet->setCellValue('C' . $summaryRow, 'Total Keseluruhan:');
        $strukSheet->setCellValue('D' . $summaryRow, '=SUM(D4:D' . ($row - 1) . ')');
        $strukSheet->getStyle('C' . $summaryRow . ':D' . $summaryRow)->getFont()->setBold(true);
        $strukSheet->getStyle('D' . $summaryRow)->applyFromArray($currencyStyle);
        $strukSheet->getStyle('D' . $summaryRow)->getNumberFormat()->setFormatCode('Rp #,##0');
    
        // Add STRUK ITEMS SHEET
        $spreadsheet->createSheet();
        $itemSheet = $spreadsheet->setActiveSheetIndex(2);
        $itemSheet->setTitle('Struk Items');
    
        // Set headers for item data
        $itemSheet->setCellValue('A1', 'Gatot AC Mobil - Data Item Struk ' . $periodText );
        $itemSheet->mergeCells('A1:G1');
        $itemSheet->getRowDimension(1)->setRowHeight(30);
        $itemSheet->getStyle('A1')->applyFromArray($titleStyle);
    
        $itemSheet->setCellValue('A3', 'ID');
        $itemSheet->setCellValue('B3', 'Struk ID');
        $itemSheet->setCellValue('C3', 'Booking ID');
        $itemSheet->setCellValue('D3', 'Item');
        $itemSheet->setCellValue('E3', 'Qty');
        $itemSheet->setCellValue('F3', 'Harga Satuan');
        $itemSheet->setCellValue('G3', 'Total Harga');
    
        $itemSheet->getRowDimension(3)->setRowHeight(20);
        $itemSheet->getStyle('A3:G3')->applyFromArray($headerStyle);
    
        // Add struk item data
        $row = 4;
        foreach ($strukItems as $item) {
            // Get associated struk to find booking_id
            $associatedStruk = $struks->firstWhere('id', $item->struk_id);
            $bookingId = $associatedStruk ? $associatedStruk->booking_id : '-';
            
            $itemSheet->setCellValue('A' . $row, $item->id);
            $itemSheet->setCellValue('B' . $row, $item->struk_id);
            $itemSheet->setCellValue('C' . $row, $bookingId);
            $itemSheet->setCellValue('D' . $row, $item->name ?? '-');
            $itemSheet->setCellValue('E' . $row, $item->quantity ?? 0);
            $itemSheet->setCellValue('F' . $row, $item->unit_price ?? 0);
            $itemSheet->setCellValue('G' . $row, $item->price ?? 0);
            
            // Apply alternating row colors
            if ($row % 2 == 0) {
                $itemSheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($alternateRowStyle);
            }
            
            $row++;
        }
    
        // Style item data
        $dataRange = 'A4:G' . ($row - 1);
        $itemSheet->getStyle($dataRange)->applyFromArray($dataStyle);
    
        // Format price columns
        $itemSheet->getStyle('F4:G' . ($row - 1))->applyFromArray($currencyStyle);
        $itemSheet->getStyle('F4:G' . ($row - 1))->getNumberFormat()->setFormatCode('Rp #,##0');
    
        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $itemSheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Add total summary
        $summaryRow = $row + 1;
        $itemSheet->setCellValue('F' . $summaryRow, 'Total Keseluruhan:');
        $itemSheet->setCellValue('G' . $summaryRow, '=SUM(G4:G' . ($row - 1) . ')');
        $itemSheet->getStyle('F' . $summaryRow . ':G' . $summaryRow)->getFont()->setBold(true);
        $itemSheet->getStyle('G' . $summaryRow)->applyFromArray($currencyStyle);
        $itemSheet->getStyle('G' . $summaryRow)->getNumberFormat()->setFormatCode('Rp #,##0');
    
        // Add RATINGS sheet if there's data
        if ($ratings->count() > 0) {
            $spreadsheet->createSheet();
            $ratingSheet = $spreadsheet->setActiveSheetIndex(3);
            $ratingSheet->setTitle('Ratings');
    
            $ratingSheet->setCellValue('A1', 'Gatot AC Mobil - Data Rating ' . $periodText . ' (Data Tetap Ada di Database)');
            $ratingSheet->mergeCells('A1:E1');
            $ratingSheet->getRowDimension(1)->setRowHeight(30);
            $ratingSheet->getStyle('A1')->applyFromArray($titleStyle);
    
            $ratingSheet->setCellValue('A3', 'ID');
            $ratingSheet->setCellValue('B3', 'Booking ID');
            $ratingSheet->setCellValue('C3', 'User');
            $ratingSheet->setCellValue('D3', 'Rating');
            $ratingSheet->setCellValue('E3', 'Review');
    
            $ratingSheet->getRowDimension(3)->setRowHeight(20);
            $ratingSheet->getStyle('A3:E3')->applyFromArray($headerStyle);
    
            // Add rating data
            $row = 4;
            foreach ($ratings as $rating) {
                $ratingSheet->setCellValue('A' . $row, $rating->id);
                $ratingSheet->setCellValue('B' . $row, $rating->booking_id);
                $ratingSheet->setCellValue('C' . $row, $rating->user ? $rating->user->name : '-');
                $ratingSheet->setCellValue('D' . $row, $rating->rating ?? '-');
                $ratingSheet->setCellValue('E' . $row, $rating->review ?? '-');
                
                // Apply alternating row colors
                if ($row % 2 == 0) {
                    $ratingSheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($alternateRowStyle);
                }
                
                $row++;
            }
    
            // Style rating data
            $dataRange = 'A4:E' . ($row - 1);
            $ratingSheet->getStyle($dataRange)->applyFromArray($dataStyle);
    
            // Set wrap text for review column
            $ratingSheet->getStyle("E4:E" . ($row - 1))->getAlignment()->setWrapText(true);
    
            // Auto-size columns
            foreach (range('A', 'D') as $col) {
                $ratingSheet->getColumnDimension($col)->setAutoSize(true);
            }
            $ratingSheet->getColumnDimension('E')->setWidth(50);
    
            // Add star visual for ratings
            for ($i = 4; $i < $row; $i++) {
                $ratingValue = $ratingSheet->getCell('D' . $i)->getValue();
                if (is_numeric($ratingValue)) {
                    $stars = str_repeat('★', intval($ratingValue)) . str_repeat('☆', 5 - intval($ratingValue));
                    $ratingSheet->setCellValue('D' . $i, $stars);
                    $ratingSheet->getStyle('D' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
            }
        }
    
        // Add summary sheet
        $spreadsheet->createSheet();
        $summarySheet = $spreadsheet->setActiveSheetIndex($ratings->count() > 0 ? 4 : 3);
        $summarySheet->setTitle('Summary');
    
        $summarySheet->setCellValue('A1', 'Gatot AC Mobil - Ringkasan Data ' . $periodText);
        $summarySheet->mergeCells('A1:C1');
        $summarySheet->getRowDimension(1)->setRowHeight(30);
        $summarySheet->getStyle('A1')->applyFromArray($titleStyle);
    
        $summarySheet->setCellValue('A3', 'Kategori');
        $summarySheet->setCellValue('B3', 'Jumlah');
        $summarySheet->setCellValue('C3', 'Detail');
        $summarySheet->getStyle('A3:C3')->applyFromArray($headerStyle);
    
        // Add summary data
        $summarySheet->setCellValue('A4', 'Booking');
        $summarySheet->setCellValue('B4', $bookings->count());
        $summarySheet->setCellValue('C4', 'Seluruh booking pada periode ' . $periodText );
    
        $summarySheet->setCellValue('A5', 'Struk');
        $summarySheet->setCellValue('B5', $struks->count());
        $summarySheet->setCellValue('C5', 'Seluruh struk dengan status terbayar');
    
        $summarySheet->setCellValue('A6', 'Item Struk');
        $summarySheet->setCellValue('B6', $strukItems->count());
        $summarySheet->setCellValue('C6', 'Seluruh item struk dari struk dengan status terbayar');
    
        $summarySheet->setCellValue('A7', 'Rating');
        $summarySheet->setCellValue('B7', $ratings->count());
        $summarySheet->setCellValue('C7', 'Seluruh rating yang terkait dengan booking yang dihapus');
    
        $summarySheet->setCellValue('A9', 'Total Pendapatan');
        $summarySheet->setCellValue('B9', '=Struks!D' . ($struks->count() + 4));
        $summarySheet->getStyle('B9')->applyFromArray($currencyStyle);
        $summarySheet->getStyle('B9')->getNumberFormat()->setFormatCode('Rp #,##0');
    
        // Style summary data
        $summarySheet->getStyle('A4:C7')->applyFromArray($dataStyle);
        $summarySheet->getStyle('A9:B9')->getFont()->setBold(true);
    
        // Auto-size columns
        foreach (range('A', 'C') as $col) {
            $summarySheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Set the summary sheet as active
        $spreadsheet->setActiveSheetIndex($ratings->count() > 0 ? 4 : 3);
    
        // Save to file
        $fileName = "Gatot_AC_Mobil_{$this->selectedYear}_{$this->selectedMonth}.xlsx";
        $filePath = "backups/{$fileName}";
    
        $writer = new Xlsx($spreadsheet);
        Storage::disk('public')->put($filePath, '');
        $writer->save(storage_path('app/public/' . $filePath));
    
        return Storage::disk('public')->url($filePath);
    }

    public function render()
    {
        return view('livewire.backup-booking', [
            'months' => $this->months,
            'years' => $this->years,
        ]);
    }
}

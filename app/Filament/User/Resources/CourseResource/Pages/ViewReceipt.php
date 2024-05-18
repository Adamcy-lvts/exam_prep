<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Models\Payment;
use Filament\Resources\Pages\Page;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use Filament\Notifications\Notification;
use App\Filament\User\Resources\CourseResource;

class ViewReceipt extends Page
{
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.view-receipt';

    public $payment;
    public $receipt;

    public function mount($record): void
    {
        // dd($record);
        $this->payment = Payment::find($record);

        $this->receipt = $this->payment->receipt;

        // dd($this->receipt->user);
    }

    public function downloadReceipt()
    {

        $pdfName = $this->payment->user->first_name . '_' . $this->payment->user->last_name . '-' . '_receipt.pdf';
        $receiptPath = storage_path("app/{$pdfName}");


        Pdf::view('pdf-receipt-view.payment-receipt', [
            'payment' => $this->payment,
            'receipt' => $this->receipt

        ])->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot->setChromePath(config('app.chrome_path'));
        })->save($receiptPath);
        
        Notification::make()
            ->title('Receipt downloaded successfully.')
            ->success()
            ->send();

        return response()->download($receiptPath, $pdfName, [
            'Content-Type' => 'application/pdf',
        ])->deleteFileAfterSend(true);
    }
}

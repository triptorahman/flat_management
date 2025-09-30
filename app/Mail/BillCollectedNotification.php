<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Bill;
use App\Models\Tenant;

class BillCollectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $tenant;
    public $totalPaidAmount;
    public $paymentDate;
    public $includedDueAmount;
    public $recipientType; // 'tenant', 'house_owner', 'admin'

    /**
     * Create a new message instance.
     */
    public function __construct(Bill $bill, Tenant $tenant, $totalPaidAmount, $paymentDate, $includedDueAmount = false, $recipientType = 'tenant')
    {
        $this->bill = $bill;
        $this->tenant = $tenant;
        $this->totalPaidAmount = $totalPaidAmount;
        $this->paymentDate = $paymentDate;
        $this->includedDueAmount = $includedDueAmount;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'tenant' ? 
            'Payment Received - ' . date('F Y', strtotime($this->bill->month)) :
            'Bill Payment Collected - Flat ' . $this->bill->flat->flat_number;
            
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bill-collected',
            with: [
                'bill' => $this->bill,
                'tenant' => $this->tenant,
                'totalPaidAmount' => $this->totalPaidAmount,
                'paymentDate' => $this->paymentDate,
                'includedDueAmount' => $this->includedDueAmount,
                'recipientType' => $this->recipientType,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

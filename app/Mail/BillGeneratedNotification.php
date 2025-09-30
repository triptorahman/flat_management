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

class BillGeneratedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $tenant;
    public $dueAmount;

    /**
     * Create a new message instance.
     */
    public function __construct(Bill $bill, Tenant $tenant, $dueAmount = 0)
    {
        $this->bill = $bill;
        $this->tenant = $tenant;
        $this->dueAmount = $dueAmount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Bill Generated - ' . date('F Y', strtotime($this->bill->month)),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bill-generated',
            with: [
                'bill' => $this->bill,
                'tenant' => $this->tenant,
                'dueAmount' => $this->dueAmount,
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

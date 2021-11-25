<?php

namespace App\Mail;

use App\Models\Delivery;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $status
     *
     * @return void
     */
    public function __construct($data, $status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $delivery = Delivery::find($data['delivery']);
        $payment = Payment::find($data['payment']);

        $subject = $this->status ? 'Оформлен заказ' : 'Попытка оформления заказа';
        return $this->subject($subject)->view('mail.order', compact('data', 'delivery', 'payment', 'subject'));
    }
}

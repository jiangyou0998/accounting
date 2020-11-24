<?php

namespace App\Mail;

use App\Models\Itsupport\Itsupport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ItSupportShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * 订单实例.
     *
     * @var Order
     */
    public $itSupport;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Itsupport $itSupport)
    {
        $this->itSupport = $itSupport;
    }

    /**
     * 构建消息.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
            ->view('emails.orders.shipped');
    }
}

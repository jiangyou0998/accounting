<?php

namespace App\Mail;


use App\Models\Claim;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClaimShipped extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * 订单实例.
     *
     * @var Claim
     */
    public $claim;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $claim = Claim::with(['employee','claim_level','illness'])
            ->find($id);

        $this->claim = $claim;
    }

    /**
     * 构建消息.
     *
     * @return $this
     */
    public function build()
    {
//        $user = Admin::user();
        $claim = $this->claim;
        $subject = '醫療索償('.$claim->employee->name.')';
//        $files = $claim->getFile();
        $mail = $this->from(env('MAIL_USERNAME','claim@ryoyubakery.com.hk'))
            ->view('emails.claim.shipped', compact('claim'))
            ->subject($subject);

        return $mail;

    }
}

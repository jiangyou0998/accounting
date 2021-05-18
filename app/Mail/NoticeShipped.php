<?php

namespace App\Mail;


use App\Models\Notice;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NoticeShipped extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * 订单实例.
     *
     * @var Notice
     */
    public $notice;
    public $from_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $name)
    {
        $notice = Notice::with('attachments')
            ->find($id);

        $this->notice = $notice;
        $this->from_name = $name  ?? 'King Bakery';
    }

    /**
     * 构建消息.
     *
     * @return $this
     */
    public function build()
    {

        $notice = $this->notice;
        $files = $notice->getFile();
        $mail = $this->from(env('MAIL_USERNAME'), $this->from_name)
            ->view('emails.notice.shipped', compact('files', 'notice'))
            ->subject($notice->notice_name);



//        if(is_array($files)){
//            foreach ($files as $file => $name){
////                $mail = $mail->attach($file);
//            }
//        }else{
//            $mail = $mail->attach($files);
//        }

        return $mail;

    }
}

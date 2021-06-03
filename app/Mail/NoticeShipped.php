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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $notice = Notice::with(['attachments','admin_role'])
            ->find($id);

        $this->notice = $notice;
    }

    /**
     * 构建消息.
     *
     * @return $this
     */
    public function build()
    {
//        $user = Admin::user();
        $notice = $this->notice;
        $files = $notice->getFile();
        $mail = $this->from(env('MAIL_USERNAME','notice@ryoyubakery.com.hk'), $notice->admin_role->name)
            ->view('emails.notice.shipped', compact('files', 'notice'))
            ->subject($notice->notice_name);

        return $mail;

    }
}

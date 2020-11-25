<?php

namespace App\Mail;

use App\Models\Itsupport\Itsupport;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ItSupportShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * 订单实例.
     *
     * @var Order
     */
    public $itSupport;

//    public $ical;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $itSupport = Itsupport::with('items')
            ->with('details')
            ->with('users')
            ->find($id);
        $this->itSupport = $itSupport;
    }

    public function ical()
    {
        $itSupport = $this->itSupport;
        //ical文件時間要用UTC
        $now = Carbon::now('UTC');
        $date = $now->isoFormat('YYYYMMDD');
        $startTime = $now->addHour(1)->isoFormat('HH');
        $endTime = $now->addHour(3)->isoFormat('HH');

        //每行前面不能加tab
        $ical_content = "BEGIN:VCALENDAR
VERSION:2.0
PRODID://Drupal iCal API//CN
BEGIN:VEVENT
UID:
DTSTAMP:".$date."T".$startTime."0000Z
DTSTART:".$date."T".$startTime."0000Z
DTEND:".$date."T".$endTime."0000Z
SUMMARY:" . $itSupport->items->name . $itSupport->details->name . "
LOCATION:" . $itSupport->users->txt_name . "
DESCRIPTION:有新的IT求助
END:VEVENT
END:VCALENDAR";

        return $ical_content;
    }

    /**
     * 构建消息.
     *
     * @return $this
     */
    public function build()
    {
//        dump($this->itSupport->toArray());
        $user = Auth::user();
        $ical = $this->ical();
//        if($this->itSupport->file_path){
//            return $this->from($user->email,$user->txt_name)
//                ->view('emails.orders.shipped')
//                ->attach($this->itSupport->file_path)
//                ->subject($user->txt_name.'18IT0082');
//        }else{
//            return $this->from($user->email,$user->txt_name)
//                ->view('emails.orders.shipped')
//                ->subject($user->txt_name.'18IT0082');
//        }
        $mail = $this->from($user->email,$user->txt_name)
            ->view('emails.orders.shipped')
            ->attachData($ical,'ical.ics')
            ->subject($user->txt_name.$this->itSupport->it_support_no);

        if($this->itSupport->file_path){
            $attachment = public_path($this->itSupport->file_path);
            $mail = $mail->attach($attachment);
        }

        return $mail;



    }
}

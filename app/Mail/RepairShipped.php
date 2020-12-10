<?php

namespace App\Mail;

use App\Models\Itsupport\Itsupport;
use App\Models\Repairs\RepairProject;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class RepairShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * 订单实例.
     *
     * @var Order
     */
    public $repair;

//    public $ical;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $repair = RepairProject::with('locations')
            ->with('items')
            ->with('details')
            ->with('users')
            ->find($id);

        $importanceArr = RepairProject::IMPORTANCE;
        if(isset($importanceArr[$repair->importance])){
            $repair->importance = $importanceArr[$repair->importance];
        }else{
            $repair->importance = "";
        }

        $this->repair = $repair;
    }

    public function ical()
    {
        $repair = $this->repair;
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
SUMMARY:" . $repair->items->name . $repair->details->name . "
LOCATION:" . $repair->users->txt_name . "
DESCRIPTION:有新的維修項目
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
//        dump($this->repair->toArray());
        $user = Auth::user();
        $ical = $this->ical();

        $mail = $this->from($user->email,$user->txt_name)
            ->view('emails.repair.shipped')
            ->attachData($ical,'ical.ics')
            ->subject($user->txt_name.$this->repair->repair_project_no);

        if($this->repair->file_path){
            $attachment = public_path($this->repair->file_path);
            $mail = $mail->attach($attachment);
        }

        return $mail;

    }
}

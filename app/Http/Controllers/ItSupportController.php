<?php

namespace App\Http\Controllers;


use App\Handlers\FileUploadHandler;
use App\Mail\ItSupportShipped;
use App\Models\Itsupport\Itsupport;
use App\Models\Itsupport\ItsupportItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ItSupportController extends Controller
{
    //
    public function index(Request $request)
    {
        $items = ItsupportItem::orderBy('sort')->get()->pluck('name','id');

        $details = ItsupportItem::with('details')->orderBy('sort')->get()->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item['details']->pluck('name','id')];
        });

        $allUnfinished = Itsupport::getUnfinishedSupport();
        $allFinished =  Itsupport::getFinishedSupport();
        $allCanceled =  Itsupport::getCanceledSupport();

        $importances = Itsupport::IMPORTANCE;

        return view('support.itsupport.index',compact('items','details' , 'importances' ,'allUnfinished' ,'allFinished','allCanceled'));
    }

    public function phoneIndex()
    {
        $allUnfinished = Itsupport::getUnfinishedSupport()->groupBy('user_id');

        $users = User::all()->pluck('txt_name', 'id');

        return view('support.itsupport.phone.index', compact('allUnfinished', 'users'));
    }

    public function store(Request $request, FileUploadHandler $uploader)
    {
        $user = Auth::user();
        $itSupportNo = Itsupport::getMaxSupportNo();

        $data['importance'] = $request->importance;
        $data['itsupport_item_id'] = $request->items;
        $data['itsupport_detail_id'] = $request->details;
        $data['machine_code'] = $request->machine_code;
        $data['other'] = $request->textarea;
        $data['status'] = Itsupport::STATUS_UNFINISHED;
        $data['user_id'] = $user->id;
        $data['last_update_user'] = $user->id;
        $data['it_support_no'] = $itSupportNo;
        $data['ip'] = $request->ip();

        //2021-11-30 增加負責人
        $data['contact_person'] = $request->contact_person;

        //保存文件
        if ($request->file) {
            $result = $uploader->save($request->file, 'itsupports', $user->id);
            if ($result) {
                $data['file_path'] = $result['path'];
            }
        }

        $itSupport = Itsupport::create($data);

        $notification_emails = getNotificationEmails('itsupport');
        if($notification_emails){
            Mail::to($notification_emails)->send(new ItSupportShipped($itSupport->id));
        }

        return redirect()->route('itsupport');
    }

    public function show($id)
    {
        $itsupport = Itsupport::with('users')
            ->with('items')
            ->with('details')
            ->find($id);
        return view('support.itsupport.show',compact('itsupport'));
    }

    public function edit($id)
    {
        $itsupport = Itsupport::with('users')
            ->with('items')
            ->with('details')
            ->find($id);

        //分解時間 (格式 11:00)
        $itsupport->finished_start_hour = substr($itsupport->finished_start_time, 0, 2);
        $itsupport->finished_start_minute = substr($itsupport->finished_start_time,  -2);
        $itsupport->finished_end_hour = substr($itsupport->finished_end_time, 0, 2);
        $itsupport->finished_end_minute = substr($itsupport->finished_end_time,  -2);

        return view('support.itsupport.edit',compact('itsupport'));
    }

    public function update(Request $request, $itsupportid)
    {
        $user = Auth::user();
        $itsupport = Itsupport::find($itsupportid);

        //時間補0後拼接
        $start_hour = str_pad($request->start_hour,2,"0", STR_PAD_LEFT);
        $start_minute = str_pad($request->start_minute,2,"0", STR_PAD_LEFT);
        $end_hour = str_pad($request->end_hour,2,"0", STR_PAD_LEFT);
        $end_minute = str_pad($request->end_minute,2,"0", STR_PAD_LEFT);
        $finished_start_time = $start_hour . ':' . $start_minute;
        $finished_end_time = $end_hour . ':' . $end_minute;

        $itsupport->comment = $request->comment;
        $itsupport->complete_date = $request->cDate;
        $itsupport->finished_start_time = $finished_start_time;
        $itsupport->finished_end_time = $finished_end_time;
        $itsupport->handle_staff = $request->staff;
        $itsupport->last_update_user = $user->id;
        $itsupport->fee = $request->fee;

        //已完成狀態改為99
        if($request->complete){
            $itsupport->status = Itsupport::STATUS_FINISHED;
        }

        $itsupport->save();

        return redirect()->route('redirect','ITSUPPORT_UPDATE_SUCCESS');

    }

    public function destroy($id)
    {
        $itsupport = Itsupport::find($id);
        $itsupport->last_update_user = Auth::id();
        $itsupport->status = Itsupport::STATUS_CANCELED;
        $itsupport->save();
    }

}

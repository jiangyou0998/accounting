<?php

namespace App\Http\Controllers;


use App\Handlers\FileUploadHandler;
use App\Mail\ItSupportShipped;
use App\Mail\RepairShipped;
use App\Models\Repairs\RepairDetail;
use App\Models\Repairs\RepairItem;
use App\Models\Repairs\RepairLocation;
use App\Models\Repairs\RepairProject;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class RepairController extends Controller
{
    //
    public function index()
    {
        $locations = RepairLocation::orderBy('sort')->get()->pluck('name','id');
        $items = RepairItem::orderBy('sort')->get()->pluck('name','id');
        $details = RepairDetail::orderBy('sort')->get()->pluck('name','id');

        $allUnfinished = RepairProject::getUnfinishedSupport();
        $allFinished =  RepairProject::getFinishedSupport();
        $allCanceled =  RepairProject::getCanceledSupport();

        $importances = RepairProject::IMPORTANCE;

        return view('support.repair.index',compact('locations' ,'items','details' , 'importances' ,'allUnfinished' ,'allFinished','allCanceled'));
    }

    public function phoneIndex()
    {
        $allUnfinished = RepairProject::getUnfinishedSupport()->groupBy('user_id');

        $users = User::all()->pluck('txt_name', 'id');

        return view('support.repair.phone.index', compact('allUnfinished', 'users'));
    }

    public function store(Request $request, FileUploadHandler $uploader)
    {
        $user = Auth::user();
        $repairNo = RepairProject::getMaxSupportNo();

        $data['importance'] = $request->importance;
        $data['repair_location_id'] = $request->locations;
        $data['repair_item_id'] = $request->items;
        $data['repair_detail_id'] = $request->details;
        $data['machine_code'] = $request->machine_code;
        $data['other'] = $request->textarea;
        $data['status'] = RepairProject::STATUS_UNFINISHED;
        $data['user_id'] = $user->id;
        $data['last_update_user'] = $user->id;
        $data['repair_project_no'] = $repairNo;
        $data['ip'] = $request->ip();

        //2021-11-30 增加負責人
        $data['contact_person'] = $request->contact_person;

        //保存文件
        if ($request->file) {
            $result = $uploader->save($request->file, 'repairs', $user->id);
            if ($result) {
                $data['file_path'] = $result['path'];
            }
        }

        $repair = RepairProject::create($data);

        $notification_emails = getNotificationEmails('repair');
        if($notification_emails){
            Mail::to($notification_emails)->send(new RepairShipped($repair->id));
        }

        return redirect()->route('repair');
    }

    public function show($id)
    {
        $repair = RepairProject::with('users')
            ->with(['locations', 'items', 'details'])
            ->find($id);

        $importanceArr = RepairProject::IMPORTANCE;
        if(isset($importanceArr[$repair->importance])){
            $repair->importance = $importanceArr[$repair->importance];
        }else{
            $repair->importance = "";
        }

        return view('support.repair.show',compact('repair'));
    }

    public function edit($id)
    {
        $repair = RepairProject::with('users')
            ->with('items')
            ->with('details')
            ->find($id);

        //分解時間 (格式 11:00)
        $repair->finished_start_hour = substr($repair->finished_start_time, 0, 2);
        $repair->finished_start_minute = substr($repair->finished_start_time,  -2);
        $repair->finished_end_hour = substr($repair->finished_end_time, 0, 2);
        $repair->finished_end_minute = substr($repair->finished_end_time,  -2);

        return view('support.repair.edit',compact('repair'));
    }

    public function update(Request $request, $repairid)
    {
        $user = Auth::user();
        $repair = RepairProject::find($repairid);

        //時間補0後拼接
        $start_hour = str_pad($request->start_hour,2,"0", STR_PAD_LEFT);
        $start_minute = str_pad($request->start_minute,2,"0", STR_PAD_LEFT);
        $end_hour = str_pad($request->end_hour,2,"0", STR_PAD_LEFT);
        $end_minute = str_pad($request->end_minute,2,"0", STR_PAD_LEFT);
        $finished_start_time = $start_hour . ':' . $start_minute;
        $finished_end_time = $end_hour . ':' . $end_minute;

        $repair->comment = $request->comment;
        $repair->complete_date = $request->cDate;
        $repair->finished_start_time = $finished_start_time;
        $repair->finished_end_time = $finished_end_time;
        $repair->handle_staff = $request->staff;
        $repair->last_update_user = $user->id;
        $repair->fee = $request->fee;

        //已完成狀態改為99
        if($request->complete){
            $repair->status = RepairProject::STATUS_FINISHED;
        }

        $repair->save();

        return redirect()->route('redirect','REPAIR_UPDATE_SUCCESS');

    }

    public function destroy($id)
    {
        $repair = RepairProject::find($id);
        $repair->last_update_user = Auth::id();
        $repair->status = RepairProject::STATUS_CANCELED;
        $repair->save();
    }

}

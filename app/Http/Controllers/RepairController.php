<?php

namespace App\Http\Controllers;


use App\Handlers\FileUploadHandler;
use App\Mail\ItSupportShipped;
use App\Mail\RepairShipped;
use App\Models\Repairs\RepairItem;
use App\Models\Repairs\RepairLocation;
use App\Models\Repairs\RepairProject;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class RepairController extends Controller
{
    //
    public function index(Request $request)
    {
        $locations = RepairLocation::all()->pluck('name','id');

        $items = RepairLocation::with('items')->get()->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item['items']->pluck('name','id')];
        });

        $details = RepairItem::with('details')->get()->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item['details']->pluck('name','id')];
        });

//        dump($items->toArray());

        $allUnfinished = RepairProject::getUnfinishedSupport();

        $allFinished =  RepairProject::getFinishedSupport();

        $allCanceled =  RepairProject::getCanceledSupport();

        $importances = RepairProject::IMPORTANCE;

//        dd($allUnfinished->toArray());

//        dump($items->toArray());

        return view('support.repair.index',compact('locations' ,'items','details' , 'importances' ,'allUnfinished' ,'allFinished','allCanceled'));
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
        $data['status'] = 1;
        $data['user_id'] = $user->id;
        $data['last_update_user'] = $user->id;
        $data['repair_project_no'] = $repairNo;
        $data['ip'] = $request->ip();


//        dd($repairNo);

//        dump($request);
//        dd($data);

        //保存文件
        if ($request->file) {
            $result = $uploader->save($request->file, 'repairs', $user->id);
            if ($result) {
                $data['file_path'] = $result['path'];
            }
        }

        $repair = RepairProject::create($data);

//        $emails = Role::getEmail('Maintenance');
//        Mail::to($emails)->send(new RepairShipped($repair->id));

        Mail::to(['jianli@kingbakery.com.hk','fs378354476@outlook.com'])->send(new RepairShipped($repair->id));
//        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
        return redirect()->route('repair');
    }

    public function show($id)
    {
        $repair = RepairProject::with('users')
            ->with('items')
            ->with('details')
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

        $importanceArr = RepairProject::IMPORTANCE;
        if(isset($importanceArr[$repair->importance])){
            $repair->importance = $importanceArr[$repair->importance];
        }else{
            $repair->importance = "";
        }

        return view('support.repair.edit',compact('repair'));
    }

    public function update(Request $request, $repairid)
    {
        $user = Auth::user();
        $repair = RepairProject::find($repairid);

//        $repair->id = $repairid;
        $repair->comment = $request->comment;
        $repair->complete_date = $request->cDate;
        $repair->finished_start_time = $request->start;
        $repair->finished_end_time = $request->end;
        $repair->handle_staff = $request->staff;
        $repair->last_update_user = $user->id;

        //已完成狀態改為99
        if($request->complete){
            $repair->status = 99;
        }

        $repair->save();

        return redirect()->route('redirect','REPAIR_UPDATE_SUCCESS');

    }

    public function destroy($id)
    {
        $repair = RepairProject::find($id);
        $repair->last_update_user = Auth::id();
        $repair->status = 4;
        $repair->save();
    }

}

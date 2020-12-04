<?php

namespace App\Http\Controllers;


use App\Handlers\FileUploadHandler;
use App\Mail\ItSupportShipped;
use App\Models\Itsupport\Itsupport;
use App\Models\Itsupport\ItsupportItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ItSupportController extends Controller
{
    //
    public function index(Request $request)
    {
        $items = ItsupportItem::all()->pluck('name','id');

        $details = ItsupportItem::with('details')->get()->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item['details']->pluck('name','id')];
        });

        $allUnfinished = Itsupport::getUnfinishedSupport();

        $allFinished =  Itsupport::getFinishedSupport();

        $allCanceled =  Itsupport::getCanceledSupport();

        $importances = Itsupport::IMPORTANCE;

//        dump($unfinisheds->toArray());

//        dump($items->toArray());

        return view('support.itsupport.index',compact('items','details' , 'importances' ,'allUnfinished' ,'allFinished','allCanceled'));
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
        $data['status'] = 1;
        $data['user_id'] = $user->id;
        $data['last_update_user'] = $user->id;
        $data['it_support_no'] = $itSupportNo;
        $data['ip'] = $request->ip();


//        dd($itSupportNo);

//        dump($request);
//        dd($data);

        //保存文件
        if ($request->file) {
            $result = $uploader->save($request->file, 'itsupports', $user->id);
            if ($result) {
                $data['file_path'] = $result['path'];
            }
        }

        $itSupport = Itsupport::create($data);

        Mail::to(['jianli@kingbakery.com.hk','fs378354476@outlook.com'])->send(new ItSupportShipped($itSupport->id));
//        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
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
        return view('support.itsupport.edit',compact('itsupport'));
    }

    public function update(Request $request, $itsupportid)
    {
        $user = Auth::user();
        $itsupport = Itsupport::find($itsupportid);

//        $itsupport->id = $itsupportid;
        $itsupport->comment = $request->comment;
        $itsupport->complete_date = $request->cDate;
        $itsupport->finished_start_time = $request->start;
        $itsupport->finished_end_time = $request->end;
        $itsupport->handle_staff = $request->staff;
        $itsupport->last_update_user = $user->id;

        //已完成狀態改為99
        if($request->complete){
            $itsupport->status = 99;
        }

        $itsupport->save();

        return redirect()->route('redirect','ITSUPPORT_UPDATE_SUCCESS');

    }

    public function destroy($id)
    {
        $itsupport = Itsupport::find($id);
        $itsupport->last_update_user = Auth::id();
        $itsupport->status = 4;
        $itsupport->save();
    }

}

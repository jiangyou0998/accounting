<?php

namespace App\Http\Controllers;


use App\Handlers\FileUploadHandler;
use App\Models\Itsupport\Itsupport;
use App\Models\Itsupport\ItsupportItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;


class ItSupportController extends Controller
{
    //
    public function index(Request $request)
    {
        $items = ItsupportItem::all()->pluck('name','id');

        $details = ItsupportItem::with('details')->get()->mapToGroups(function ($item, $key) {
            return [$item['id'] => $item['details']->pluck('name','id')];
        });

        $unfinisheds = Itsupport::with('users')
            ->with('items')
            ->with('details')
            ->where('status',1)
            ->orderByDesc('created_at')
            ->get();

//        dump($unfinisheds->toArray());

//        dump($items->toArray());

        return view('support.itsupport.index',compact('items','details' ,'unfinisheds'));
    }

    public function store(Request $request, FileUploadHandler $uploader)
    {
        $user = Auth::user();

        $data['importance'] = $request->importance;
        $data['itsupport_item_id'] = $request->items;
        $data['itsupport_detail_id'] = $request->details;
        $data['machine_code'] = $request->machine_code;
        $data['other'] = $request->textarea;
        $data['status'] = 1;
        $data['user_id'] = $user->id;
        $data['last_update_user'] = $user->id;
        //todo 設計一個編號
        $data['it_support_no'] = '20IT0001';
        $data['ip'] = $request->ip();

//        dump($request);
//        dd($data);

        //保存文件
        if ($request->file) {
            $result = $uploader->save($request->file, 'itsupports', $user->id);
            if ($result) {
                $data['file_path'] = $result['path'];
            }
        }

        Itsupport::create($data);
//        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
        return redirect()->route('itsupport');
    }

}

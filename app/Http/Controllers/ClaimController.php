<?php

namespace App\Http\Controllers;


use App\Handlers\FileUploadHandler;
use App\Models\Claim;
use App\Models\ClaimLevel;
use App\Models\Employee;
use App\Models\Itsupport\Itsupport;
use App\Models\SelectorItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;


class ClaimController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::getEmployees(365);

//        dump(old());
//        dump($employees->toArray());
        $claim_levels = ClaimLevel::getClaimLevelsGroupByPlanNo();

//        $claims = Claim::where('status', 1)->get()->groupBy('employee_id');

        $claim_illness = SelectorItem::getSelectorItems('claim_illness')
            ->pluck('item_name', 'id');

//        dump($claim_illness->pluck('item_name', 'id')->toArray());
//        dump($claim_levels->toArray());
//        dump($request->old('employee'));

        return view('hr.claim.index',compact('employees', 'claim_levels', 'claim_illness'));
    }

    public function store(Request $request, FileUploadHandler $uploader)
    {
        $employee_id = $request->employee;
        $claim_level_id =$request->claim_level_id;
        $claim_date = $request->claim_date;

//        dd($request->toArray());
        $data['employee_id'] = $request->employee;
        $data['claim_level_id'] = $request->claim_level_id;
        $data['illness_id'] = $request->claim_illness;
        $data['cost'] = $request->cost;
        $data['claim_cost'] = Claim::calculateClaimCost($request->cost, $request->claim_level_id, $request->claim_date);
        $data['claim_date'] = $request->claim_date;
        $data['status'] = Claim::STATUS_APPLYING;

        //申請次數檢測
        $is_over_times = Claim::checkClaimTimes($employee_id, $claim_level_id, $claim_date);
        if($is_over_times === false){
            session()->flash('danger', '申請次數達到上限！');
            return redirect()->back()->withInput();
        }

        //todo 入職一年才能索償

        //只能申請90天內
        $expired_day = 90;
        $is_vaild_date = Claim::checkExpiredDate($claim_date, $expired_day);
        if($is_vaild_date === false){
            session()->flash('danger', '只能在'.$expired_day.'天內申請！');
            return redirect()->back()->withInput();
        }

        //保存文件
        if ($request->file) {
            $result = $uploader->save($request->file, 'claim', $employee_id);
            if ($result) {
                $data['file_path'] = $result['path'];
            }
        }else{
            //上傳文件檢測
            session()->flash('danger', '必須上傳文件！');
            return redirect()->back()->withInput();
        }

        $claim = Claim::create($data);

//        $emails = Role::getEmail('IT');
//        Mail::to($emails)->send(new ItSupportShipped($itSupport->id));

//        Mail::to([0=>'jianli@kingbakery.com.hk',1=>'fs378354476@outlook.com'])->send(new ItSupportShipped($itSupport->id));
//        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
        return redirect()->route('claim')->with('success', '成功提交申請！');
    }

    public function claimMessage(Request $request)
    {
        $employee_id = $request->employee_id;
        $claim_level_id = $request->claim_level_id;
        $claim_date = Carbon::now()->toDateString();

        $data = Claim::getClaimMessage($employee_id, $claim_level_id, $claim_date);

//        dump($data);
        return json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}

<?php

namespace App\Http\Controllers;


use App\Http\Requests\RepairOrderRequest;
use App\Models\Repairs\RepairOrder;
use App\Models\Repairs\RepairProject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RepairOrderController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $shop_id = (int)$request->input('shop_id');
        $order_ids = $request->input('order_ids');

        if ( ! $user->can('maintenance')) {

            //分店只能開自己分店單
            if($shop_id !== $user->id){
                abort(403, '無權限修改');
            }
        }

        $orderIDArr = explode(',', $order_ids);

        $order_items = RepairProject::query()
            ->with(['locations', 'items', 'details'])
            ->whereIn('id', $orderIDArr)
            ->where('user_id', $shop_id)
            ->where('status', RepairProject::STATUS_UNFINISHED)
            ->get();
//        dump($order_items->toArray());
        $shop_name = User::find($shop_id)->txt_name ?? '';

        $maintenance_staff = User::role('maintenance')->get('txt_name');

        return view('support.repair.repair_order.index', compact('order_items', 'shop_name', 'shop_id', 'maintenance_staff'));
    }

    public function store(RepairOrderRequest $request)
    {
        // 开启事务
        DB::transaction(function () use ($request) {

            $shop_id = $request->shop_id;
            $data['user_id'] = $shop_id;
            $orderNo = RepairOrder::getMaxOrderNo($shop_id);
            $data['order_no'] = $orderNo;
            $data['complete_date'] = $request->complete_date;

            //時間補0後拼接
            $start_hour = str_pad($request->start_hour,2,"0", STR_PAD_LEFT);
            $start_minute = str_pad($request->start_minute,2,"0", STR_PAD_LEFT);
            $end_hour = str_pad($request->end_hour,2,"0", STR_PAD_LEFT);
            $end_minute = str_pad($request->end_minute,2,"0", STR_PAD_LEFT);
            $finished_start_time = $start_hour . ':' . $start_minute;
            $finished_end_time = $end_hour . ':' . $end_minute;

            $data['finished_start_time'] = $finished_start_time;
            $data['finished_end_time'] = $finished_end_time;
            $data['handle_staff'] = $request->handle_staff;

            $repair_order = RepairOrder::create($data);

            // 遍历用户提交的数据
            $items = $request->items;

            foreach ($items as &$item){
                //true 已完成, false 未完成(switch插件返回的是字符串)
                if( $item['status'] === 'true' ){
                    $item['status'] = RepairProject::STATUS_FINISHED;
                }elseif ($item['status'] === 'false'){
                    $item['status'] = RepairProject::STATUS_FINISHED;
                    //複製一條數據
                    $newRepairProject = RepairProject::find($item['id'])->replicate();
                    $newRepairProject->comment = $item['comment'] ?? '';
                    $newRepairProject->fee = $item['fee'] ?? 0;
                    $newRepairProject->save();
                    //複製數據後狀態設置成「需跟進」
                    $item['status'] = 11;
                }
                $item['repair_order_id'] = $repair_order->id;
                //不填寫費用默認為0
                $item['fee'] = $item['fee'] ?? 0;
                RepairProject::where('id', $item['id'])->update($item);
            }
            unset($item);

        });

        return;
    }

}

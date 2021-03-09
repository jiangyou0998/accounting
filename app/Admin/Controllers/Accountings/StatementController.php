<?php

namespace App\Admin\Controllers\Accountings;

use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class StatementController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('分店STATEMENT')
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

            $grid->header(function ($collection) {

                $month = $this->getMonth();

                // 标题和内容
                $cardInfo = $month;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

            $month = $this->getMonth();

            $data = $this->generate($month);
//            dump($data->toArray());

            $grid->number();
            if (count($data) > 0) {
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $values) {

                    if($key == 'id'){
                        $grid->column('id','查看')->display(function ($id) use($month){
                            return '<a href="' . route('admin.statement.view', ['shop' => $id , 'month' => $month]) .'" target="_blank">查看</a>';
                        });
                    }else{
                        $grid->column($key);
                    }
                }
            }

            // 禁用行选择器
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disablePagination();

            // 设置表格数据
            $grid->model()->setData($data);

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();

                $filter->month('month', '報表日期');
            });

        });

    }

    //statement
    public function statement(Request $request)
    {
        $now = Carbon::now();
        //如果URL沒有送貨日期,使用當日日期
        if(isset($request->deli_date)){
            $deli_date = $request->deli_date;
        }else{
            $deli_date = $now->toDateString();
        }

        //根據權限獲取商店id
        $shopid = $request->shop ?? 42;

        $month = $this->getMonth();

        $datas = $this->generateStatement($month ,$shopid);
//        dump($datas->toArray());

        $total = (float)0;
        foreach ($datas as $data){
            $total += $data->Total;
        }
//        dump($total);
//        dump($details->toArray());
//        dump($totals->toArray());

        $user = User::with('address')->find($shopid);
        $address = $user->address;

        $start_date = (new Carbon($month))->firstOfMonth()->toDateString();
        $end_date = (new Carbon($month))->endOfMonth()->toDateString();

        //頁面顯示數據
        $infos = new Collection();
        $infos->deli_date = $deli_date;
        $infos->shop = $shopid;
        $infos->shop_name = $user->txt_name;
        $infos->now = $now->toDateTimeString();
        $infos->start_date = $start_date;
        $infos->end_date = $end_date;
        $infos->company_name = $user->company_english_name ?? '';
        $infos->address = $address->address ?? '';
        $infos->phone = $address->tel ?? '';
        $infos->fax = $address->fax ?? '';
        $infos->total = $total;
        $infos->pocode_prefix = $user->pocode;
//        dump($infos);

        return view('admin.statement.index',compact('datas','infos'));
    }

    /**
     * 生成数据
     *
     */
    public function generate($month)
    {
        $start = (new Carbon($month))->firstOfMonth()->toDateString();
        $end = (new Carbon($month))->endOfMonth()->toDateString();

        $testids = User::getTestUserIDs();

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select('users.report_name as 分店');

        //查詢本月
        $sql = "ROUND(sum(
            case when (workshop_cart_items.deli_date between '$start' and '$end')
            then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2)
            as Total";
        $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        $cartitem = $cartitem
            ->addSelect('users.id');

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->whereBetween('workshop_cart_items.deli_date', [$start, $end])
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereNotIn('users.id', $testids)
            ->groupBy('users.id')
            ->orderBy('users.name')
            ->get();

//        dd($cartitem->toArray());

        return $cartitem;

    }

    /**
     * 生成Statement数据
     *
     */
    public function generateStatement($month, $shopid)
    {

        $testids = User::getTestUserIDs();

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select(DB::raw("DATE_format(deli_date,'%Y-%m-%d') as day"))
            ->addSelect(DB::raw("(DATE_FORMAT(deli_date,'%e')-1) div 7 as week"))

            ->addSelect(DB::raw('ROUND(sum(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) , 2) as Total'));

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
//            ->where('users.type', '=', 2)
            ->where('users.id', '=', $shopid)
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereNotIn('users.id', $testids)
            ->whereRaw(DB::raw("deli_date like '%$month%' "))
            ->groupBy(DB::raw('week,day'))
            ->get();

        foreach ($cartitem as $value){
            if($value->day){
                $value->week = (new Carbon($value->day))->isoFormat('dd');
            }else{
                $value->week = '';
            }
        }

        return $cartitem;
    }

    public function getMonth()
    {
        $month = (request()->month) ?? (Carbon::now()->subMonth()->isoFormat('Y-MM'));
        return $month;
    }

}

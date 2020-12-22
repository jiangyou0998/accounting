<?php

namespace App\Admin\Controllers\Reports;

use App\Models\OrderZDept;
use App\Models\TblUser;
use App\Models\WorkshopCartItem;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\DB;


//分店每月銷售總額報告
class TotalSalesByGroupReportController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('分店每月銷售總額報告')
            ->body($this->grid());
    }

    protected function grid()
    {
        return new Grid(null, function (Grid $grid) {

            $grid->header(function ($collection) {
                $start = $this->getStartTime();
                $end = $this->getEndTime();

                // 标题和内容
                $cardInfo = $start." 至 ".$end ;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

            $start = $this->getStartTime();
            $end = $this->getEndTime();

            $data = $this->generate($start,$end);

            if(count($data) > 0){
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $values){

                    $grid->column($key);

                }
            }

            $grid->withBorder();

            //禁用 导出所有 选项
            $grid->export()->disableExportAll();
            //禁用 导出选中行 选项
            $grid->export()->disableExportSelectedRow();
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

                $filter->between('between', '報表日期')->date();


            });

            $filename = '分店每月銷售總額報告 '.$start.'至'.$end ;
            $grid->export()->csv()->filename($filename);


            });

    }

    /**
     * 生成数据
     *
     * @return array
     */
    public function generate($start,$end) {

        $shops = User::getKingBakeryShops();

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select('workshop_cats.cat_name as 大類' )
            ->addSelect('workshop_groups.group_name as 細類')
            ->addSelect(DB::raw('ROUND(sum(ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) , 2) as Total'));

            foreach ($shops as $shop){
//                $sql = "sum(case when workshop_cart_items.user = '$shop->id' then workshop_cart_items.qty else 0 end) as '$shop->report_name'";
//                dump($sql);
                $sql = "ROUND(sum(case when workshop_cart_items.user_id = '$shop->id' then (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price) else 0 end),2) as '$shop->report_name'";
                $cartitem = $cartitem
                    ->addSelect(DB::raw($sql));
            }

       $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('workshop_groups', 'workshop_products.group_id', '=', 'workshop_groups.id')
            ->leftJoin('workshop_cats', 'workshop_groups.cat_id', '=', 'workshop_cats.id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id')
            ->where('users.type', '=', 2)
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereRaw("deli_date between '$start' and '$end'")
            ->groupBy('workshop_groups.id')
            ->orderBy('workshop_cats.sort')
            ->orderBy('workshop_groups.id')
            ->get();

//        dd($cartitem->toArray());

        return $cartitem;

    }

    public function getStartTime(){
        if(isset($_REQUEST['between']['start'])){
            $start = $_REQUEST['between']['start'];
        }else{
            //上个月第一天
            $start = Carbon::now()->subMonth()->firstOfMonth()->toDateString();
        }
        return $start;
    }

    public function getEndTime(){
        if(isset($_REQUEST['between']['end'])){
            $end = $_REQUEST['between']['end'];
        }else{
            //上个月最后一天
            $end = Carbon::now()->subMonth()->lastOfMonth()->toDateString();
        }
        return $end;
    }

    public function headings(): array
    {
        $shops = TblUser::getKingBakeryShops();

        $headings = ['編號','名稱','Total'];
        foreach ($shops as $shop){
            array_push($headings,$shop->report_name);
        }

        return $headings;
    }
}

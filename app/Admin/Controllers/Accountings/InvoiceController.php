<?php

namespace App\Admin\Controllers\Accountings;

use App\Admin\Forms\Invoice;
use App\Admin\Renderable\ShopTable;
use App\Admin\Traits\InvoiceTraits;
use App\Admin\Traits\ReportTimeTraits;
use App\Models\WorkshopCartItem;
use App\User;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends AdminController
{
//    use NumberToEnglishTraits;
    use ReportTimeTraits, InvoiceTraits;

    private const ITEM_COUNT_PER_PAGE = 38;

    public function index(Content $content)
    {
        return $content
            ->header('分店INVOICE')
            ->body($this->render())
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

//            $grid->tools(new Invoice());

            $grid->header(function ($collection) {

                $start = $this->getStartTime('today');
                $end = $this->getEndTime('today');

                // 标题和内容
                $cardInfo = $start . " 至 " . $end;
                $card = Card::make('日期:', $cardInfo);

                return $card;
            });

//            $month = $this->getMonth();

            $start = $this->getStartTime('today');
            $end = $this->getEndTime('today');
            $pocode = request()->pocode;

            //選中的商店id
            $shop_id = request()->shop_id ?? "";
            $shop_group = request()->group ?? 'all';

            $data = $this->generate($start,$end,$pocode,$shop_id,$shop_group);

            $grid->number();
            if (count($data) > 0) {
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $value) {
                    if($key == 'id'){
                        $grid->column('id','查看')->display(function ($id){
                            return '<a href="' . route('admin.invoice.view', ['shop' => $id , 'deli_date' => $this->deli_date]) .'" target="_blank">查看</a>';
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
                $filter->between('between', '報表日期')->date();
                $filter->equal('shop_id', '分店')
                    ->multipleSelectTable(ShopTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(User::class, 'id', 'txt_name'); // 设置编辑数据显示
                $filter->equal('group', '分組')->select(config('report.report_group'));
                $filter->like('pocode', 'PO');

            });

        });

    }

    //invoice
    public function invoice(Request $request)
    {
        $allData = $this->getInoviceData($request);

        return view('admin.invoice.index',compact('allData'));
    }


    //delivery note
    public function delivery(Request $request)
    {
        $allData = $this->getInoviceData($request);

        return view('admin.delivery.index',compact('allData'));
    }


    /**
     * 生成数据
     *
     */
    public function generate($start, $end, $pocode, $shop_id, $shop_group)
    {
        $testids = User::getTestUserIDs();
        $shop_ids = explode(',', $shop_id);

        if($start == '' && $end != '') $start = '0000-01-01';
        if($end == '' && $start != '') $end = '9999-12-31';
        if($pocode != '' && $start == '' && $end == ''){
            $start = '0000-01-01';
            $end = '9999-12-31';
        }

        $shops = User::getAllShops();
        $shopgroupids = $shops->pluck('id');

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select('users.report_name as 分店');

        //查詢PO
        $sql = "CONCAT(users.pocode, date_format(workshop_cart_items.deli_date, '%y%m%d'))
            as PO";
        $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        //查詢Total
        $sql = "ROUND(sum(
            (ifnull(workshop_cart_items.qty_received,workshop_cart_items.qty) * workshop_cart_items.order_price)),2)
            as Total";
        $cartitem = $cartitem
            ->addSelect(DB::raw($sql));

        $cartitem = $cartitem
            ->addSelect('workshop_cart_items.deli_date')
            ->addSelect('users.id');

        $cartitem = $cartitem
            ->leftJoin('workshop_products', 'workshop_products.id', '=', 'workshop_cart_items.product_id')
            ->leftJoin('users', 'users.id', '=', 'workshop_cart_items.user_id');

        if ($shop_id) {
            $cartitem = $cartitem->whereIn('users.id', $shop_ids);
        }

        $cartitem = $cartitem
            ->whereBetween('workshop_cart_items.deli_date', [$start, $end])
            ->where('workshop_cart_items.status', '<>', 4)
            ->whereIn('workshop_cart_items.user_id', $shopgroupids)
            ->whereNotIn('users.id', $testids)
            ->groupBy('users.id','workshop_cart_items.deli_date')
            ->orderBy('users.name');

        if($pocode){
            $cartitem = $cartitem
                ->having('PO','like',"%{$pocode}%");
        }

        $cartitem = $cartitem->get();
//        dd($cartitem->toArray());
        return $cartitem;
    }

    // 普通非异步弹窗
    // 批量生成Invoice
    protected function batchInvoice()
    {
        return Modal::make()
            ->lg()
            ->title('批量預覽')
            ->body(Invoice::make())
            ->button('<button class="btn btn-white"><i class="feather icon-grid"></i>&nbsp;批量預覽</button>');
    }

    protected function render()
    {
        return <<<HTML
{$this->batchInvoice()}
<br><br>
HTML;
    }

}

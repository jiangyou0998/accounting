<?php

namespace App\Admin\Controllers\Accountings;

use App\Admin\Forms\CustomerDelivery;
use App\Admin\Forms\CustomerInvoice;
use App\Admin\Forms\CustomerPoEdit;
use App\Admin\Renderable\CustomerShopTable;
use App\Admin\Traits\InvoiceTraits;
use App\Admin\Traits\ReportTimeTraits;
use App\Models\WorkshopCartItem;
use App\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Support\Facades\DB;


class CustomerInvoiceController extends AdminController
{
//    use NumberToEnglishTraits;
    use ReportTimeTraits, InvoiceTraits;

    private const ITEM_COUNT_PER_PAGE = 38;

    public function index(Content $content)
    {
        return $content
            ->header('外客INVOICE')
            ->body($this->render())
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(null, function (Grid $grid) {

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

            $customerPoArr = $this->getCustomerPoArr();

            $grid->number();
            if (count($data) > 0) {
                $keys = $data->first()->toArray();
                foreach ($keys as $key => $value) {
                    if($key == 'id'){
                        $grid->column('customer_po','外客po')->display(function () use($customerPoArr){
                            return $customerPoArr[$this->id][$this->deli_date] ?? '';
                        });
                        $grid->column('customer_po_edit','外客po')
                            ->display(function () use($customerPoArr){
                                return Modal::make()
                                    ->lg()
                                    ->title('修改PO')
                                    ->body(CustomerPoEdit::make($this->id, $this->shop_name, $this->deli_date, $customerPoArr[$this->id][$this->deli_date] ?? ''))
                                    ->button('<button class="btn btn-white"><i class="feather icon-grid"></i>&nbsp;修改PO</button>');;
                            });
                        $grid->column('id2','查看Delivery Note')->display(function (){
                            return '<button class="viewD btn btn-success" data-shop="'.$this->id.'" data-delidate="'.$this->deli_date.'">查看</button>';
                        });
                        $grid->column('id','查看Invoice')->display(function (){
                            return '<button class="view btn btn-primary" data-shop="'.$this->id.'" data-delidate="'.$this->deli_date.'">查看</button>';
                        });
                    }elseif($key == 'R_PO'){
                        $grid->column('rpo','查看R單')->display(function (){
                            if($this->R_PO){
                                return '<button class="viewR btn btn-danger" data-shop="'.$this->id.'" data-delidate="'.$this->deli_date.'">查看</button>';
                            }
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
                    ->multipleSelectTable(CustomerShopTable::make()) // 设置渲染类实例，并传递自定义参数
                    ->title('弹窗标题')
                    ->dialogWidth('50%') // 弹窗宽度，默认 800px
                    ->model(User::class, 'id', 'txt_name'); // 设置编辑数据显示
//                $filter->equal('group', '分組')->select(config('report.report_group'));
                $filter->like('pocode', 'PO');

            });

            //查看按鈕點擊事件
            Admin::script(
                <<<JS
$('.view').click(function () {
    let shop = $(this).data('shop');
    let deli_date = $(this).data('delidate');
    let type = 'CU';
    let url = '/admin/reports/invoice/view?shop=' + shop + '&deli_date=' + deli_date + '&type=' + type;
    window.open(url);
});

$('.viewD').click(function () {
    let shop = $(this).data('shop');
    let deli_date = $(this).data('delidate');
    let type = 'CU';
    let url = '/admin/reports/delivery/view?shop=' + shop + '&deli_date=' + deli_date + '&type=' + type;
    window.open(url);
});

$('.viewR').click(function () {
    let shop = $(this).data('shop');
    let deli_date = $(this).data('delidate');
    let type = 'CUR';
    let url = '/admin/reports/invoice/view?shop=' + shop + '&deli_date=' + deli_date + '&type=' + type;
    window.open(url);
});
JS
            );

        });

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

        $shops = User::getCustomerShops();

        $shopgroupids = $shops->pluck('id');

        $cartitem = new WorkshopCartItem();
        $cartitem = $cartitem
            ->select('users.report_name as shop_name');

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
            ->addSelect('users.id')
            //只要有修改過的就判斷有R單
            ->addSelect(DB::raw('MAX(NOT ISNULL(workshop_cart_items.qty_received)) as R_PO'));

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
            ->orderBy('users.name')
            ->having('PO','like',"%{$pocode}%")
            ->get();
//        dd($cartitem->toArray());
        return $cartitem;
    }

    // 普通非异步弹窗
    // 批量生成Invoice
    protected function batchInvoice()
    {
        return Modal::make()
            ->lg()
            ->title('批量預覽Invoice')
            ->body(CustomerInvoice::make())
            ->button('<button class="btn btn-white"><i class="feather icon-grid"></i>&nbsp;批量預覽Invoice</button>');
    }

    // 批量生成Delivery
    protected function batchDelivery()
    {
        return Modal::make()
            ->lg()
            ->title('批量預覽Delivery')
            ->body(CustomerDelivery::make())
            ->button('<button class="btn btn-success"><i class="feather icon-grid"></i>&nbsp;批量預覽Delivery</button>');
    }

    protected function editCustomerPo($shop_id , $deli_date)
    {
        return Modal::make()
            ->lg()
            ->title('修改PO')
            ->body(CustomerPoEdit::make($shop_id , $deli_date))
            ->button('<button class="btn btn-white"><i class="feather icon-grid"></i>&nbsp;修改PO</button>');
    }

    //生成頂部按鈕
    protected function render()
    {
        return <<<HTML
{$this->batchInvoice()}
{$this->batchDelivery()}
<br><br>
HTML;
    }

}

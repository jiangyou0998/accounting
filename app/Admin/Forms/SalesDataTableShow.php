<?php

namespace App\Admin\Forms;

use App\Models\ShopGroup;
use App\User;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

//營業數報告->營業數查詢 按鈕
class SalesDataTableShow extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {

        $idArr = $input['user_ids'] ?? null;
        $ids = implode('-', $idArr);
        $start_date = $input['start_date'] ?? null;
        $end_date = $input['end_date'] ?? null;

        $url = route('admin.sales_data.print', ['shop' => $ids , 'start_date' => $start_date, 'end_date' => $end_date]);

        return $this->ajaxResponse($url);
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->date('start_date','開始日期')->required();
        $this->date('end_date','結束日期')->required();
        $shopGroupIds = ShopGroup::has('users')
            ->whereIn('id',[1])
            ->pluck('name','id')
            ->toArray();
        foreach ($shopGroupIds as $shopGroupId => $shopGroupName){
            $this->checkbox('user_ids',$shopGroupName)
                ->canCheckAll()
                ->options(User::getShopsByShopGroup($shopGroupId)->pluck('report_name', 'id'))
                ->required();
        }
    }

    /**
     * 设置表单保存成功后执行的JS
     *
     * v1.6.5 版本之前请用 buildSuccessScript 方法
     *
     * @return string|void
     */
    protected function addSavedScript()
    {
        return <<<JS
        // data 为接口返回数据
        if (! data.status) {
            Dcat.error(data.message);

            return false;
        }

        // if (data.redirect) {
        //     Dcat.open(data.redirect)
        // }
        window.open(data.message);

        // 中止后续逻辑（默认逻辑）
        return false;
JS;
    }
}

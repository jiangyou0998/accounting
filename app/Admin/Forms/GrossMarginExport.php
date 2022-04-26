<?php

namespace App\Admin\Forms;

use App\Models\ShopGroup;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

//營業數報告->全部下載 按鈕
class GrossMarginExport extends Form
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
        $month = $input['month'] ?? null;

        $url = route('admin.export.gross_margin', ['shop' => $ids , 'month' => $month]);

        return $this->ajaxResponse($url);
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->month('month','月份')->format('YYYY-MM')->required();
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
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'month'  => Carbon::now()->subMonth()->isoFormat('YYYY-MM'),
        ];
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

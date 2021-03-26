<?php

namespace App\Admin\Forms;

use App\Models\ShopGroup;
use App\User;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class Invoice extends Form
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
//         dump($input['user_ids']);
        $idArr = $input['user_ids'] ?? null;
        $ids = implode('-', $idArr);
        $deli_date = $input['deli_date'] ?? null;

        $url = route('admin.invoice.view', ['shop' => $ids , 'deli_date' => $deli_date]);
//         dump($ids);
        // return $this->error('Your error message.');

        return $this->ajaxResponse($url);
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->date('deli_date','日期')->required();
        $shopGroupIds = ShopGroup::has('users')
            ->whereIn('id',[1,5])
            ->pluck('name','id')
            ->toArray();
        foreach ($shopGroupIds as $shopGroupId => $shopGroupName){
            $this->checkbox('user_ids',$shopGroupName)
                ->canCheckAll()
                ->options(User::getShopsByShopGroup($shopGroupId)->pluck('report_name', 'id'));
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
            'deli_date'  => Carbon::now()->toDateString(),
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

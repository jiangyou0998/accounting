<?php

namespace App\Admin\Extensions\Tools;

use App\Models\WorkshopCartItem;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

//下單內容查詢 頁面批量將選中項status變成4
class BatchCartItemDelete extends BatchAction
{
    protected $action;

    // 注意action的构造方法参数一定要给默认值
    public function __construct($title = null, $action = 1)
    {
        $this->title = $title;
        $this->action = $action;
    }

    // 确认弹窗信息
    public function confirm()
    {
        return '您確定要刪除已選中的下單記錄嗎？';
    }

    // 处理请求
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();

        // 获取请求参数
        $action = $request->get('action');

        foreach (WorkshopCartItem::find($keys) as $item) {
            $item->status = $action;
            $item->save();
        }

        $message = ($action === 4) ? '刪除成功' : '恢復成功';

        return $this->response()->success($message)->refresh();
    }

    // 设置请求参数
    public function parameters()
    {
        return [
            'action' => $this->action,
        ];
    }
}

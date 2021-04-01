<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CustomerPoEdit extends Form
{
    private $shop_id;
    private $shop_name;
    private $deli_date;
    private $po;

    public function __construct($shop_id = null, $shop_name = null , $deli_date = null, $po = null)
    {
        parent::__construct();
        $this->shop_id = $shop_id;
        $this->shop_name = $shop_name;
        $this->deli_date = $deli_date;
        $this->po = $po;
    }

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        DB::table('customer_pos')
            ->updateOrInsert(
                ['shop_id' => $input['shop_id'], 'deli_date' => $input['deli_date']],
                ['po' => $input['po']]
            );

        return $this->success('更新成功',$this->getCurrentUrl());
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('shop_id')->default($this->shop_id);
        $this->hidden('deli_date')->default($this->deli_date);
        $this->display('shop_name_show','分店')->default($this->shop_name);
        $this->display('deli_date_show','送貨日期')->default($this->deli_date);
        $this->text('po')->default($this->po);
    }

    /**
     * 返回请求接口的参数，如不需要可以删除此方法
     *
     * @return array
     */
    protected function parameters()
    {
        return [
            'shop_id' => $this->shop_id,
            'deli_date' => $this->deli_date,
        ];
    }

    //重寫跳轉url
    protected function getCurrentUrl(Request $request = null)
    {
        /* @var Request $request */
        $request = $request ?: (empty($this->request) ? request() : $this->request);

        if ($current = $request->get(static::CURRENT_URL_NAME)) {
            return admin_url($current);
        }

        $query = $request->query();

        return url($request->path().'?'.http_build_query($query));
    }

}

<?php

namespace App\Admin\Forms;

use App\Exports\SalesByShopAndMenuExport;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Form;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportReport extends Form
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
//        dump($input);
//        Excel::download(new SalesByShopAndMenuExport(), 'users.xls');
        return $this->ajaxResponse($input['starttime']);

//        Excel::download(new SalesByShopAndMenuExport(), 'users.xls');
//         return $this->error($input);

//        return $this->success('Processed successfully.', '/');
//        return
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $info = '<i class="fa fa-exclamation-circle"></i> 請選擇要生成的報告';

        $this->html(Alert::make($info)->info());

        $this->select('select', '報告名稱')
            ->options(['1.分店每月銷售報告數量', '2', '3', '4'])
            ->required();


        $this->divider();

        $this->dateRange('starttime', 'endtime', '報表日期')->required();


        $this->text('form1.textarea', '文件名');
        $this->radio('form1.saveradio', '保存格式')
            ->options(['xls', 'xlsx'])->default(0);
        $this->divider();
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name'  => 'John Doe',
            'email' => 'John.Doe@gmail.com',
        ];
    }
}

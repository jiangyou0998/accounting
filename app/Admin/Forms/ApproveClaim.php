<?php

namespace App\Admin\Forms;

use App\Models\Claim;
use App\Models\ClaimLevel;
use App\Models\ClaimLevelDetail;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class ApproveClaim extends Form implements LazyRenderable
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        // dump($input);

        // return $this->error('Your error message.');

//        return $this->success('Processed successfully.', '/');

        // 获取外部传递参数
        $id = $this->payload['id'] ?? null;

        $status = $input['status'] ?? null;
        $remark = $input['remark'] ?? null;
//        dump($id);
//        dump($status);


        // 索償审核
        $claim = Claim::find($id);

        if($status == Claim::STATUS_APPROVED){
            $claim_date = $claim->claim_date;
            $employee_id = $claim->employee_id;
            $claim_level_id = $claim->claim_level_id;
            $times_of_day = Claim::getTimesOfDay($employee_id, $claim_level_id, $claim_date, $id);

            $times_of_year = Claim::getTimesOfYear($employee_id, $claim_level_id, $claim_date, $id);

            $claim_level = ClaimLevelDetail::getClaimLevelDetail($claim_level_id, $claim_date);
            $times_per_day = $claim_level->times_per_day;
            $times_per_year = $claim_level->times_per_year;

//            dump($times_per_day);
//            dump($times_of_day);
            if($times_per_day <= $times_of_day){
                return $this->error('該日索償次數超過最大值');
            }

            if($times_per_year <= $times_of_year){
                return $this->error('該年份索償次數超過最大值');
            }

//        dump($claim_level);
//
//        dump('$year_start:'.$year_start);
//        dump('$year_end:'.$year_end);
//        dump('$time_of_day:'.$times_of_day);
//        dump('$times_of_year:'.$times_of_year);
//        dd($claim->employee_id);
        }


        $claim->status = $status;
        $claim->remark = $remark;
        $claim->approver_id = Admin::user()->id;
        $claim->save();

//        dd(request());
//        return $this->addSavedScript();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $id = $this->payload['id'];
        $claim = Claim::find($id);
        $status = $claim->status;
//        $this->confirm('您确定要提交表单吗');
        $this->html('<img src="'.$claim->file_path.'" alt=""  width="500">', '圖片');
        $this->radio('status', '審批狀態')->options([ 0 => '申請中', 1 => '已批核', 2 => '不理賠'])->default($status)->required();
        $this->text('remark', '備註');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [

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

        Dcat.success('審批成功');

        if (data.redirect) {
            //reload頁面,保留搜索條件
            Dcat.reload();
        }

        // 中止后续逻辑（默认逻辑）
        return false;
JS;
    }

}

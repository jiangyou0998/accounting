<?php

namespace App\Admin\Traits;

use Carbon\Carbon;

trait ReportTimeTraits
{
    public function getStartTime($day)
    {
        if (isset($_REQUEST['between']['start'])) {
            $start = $_REQUEST['between']['start'];
        } else {
            //上个月第一天
            $start = $this->getDefaultDay($day);
        }
        return $start;
    }

    public function getEndTime($day)
    {
        if (isset($_REQUEST['between']['end'])) {
            $end = $_REQUEST['between']['end'];
        } else {
            //上个月最后一天
            $end = $this->getDefaultDay($day);
        }
        return $end;
    }

    public function getDefaultDay($day = '')
    {
        $default_day = '';
        switch ($day){
            case 'today':
                $default_day = Carbon::now()->toDateString();
                break;
            case 'last_month_first':
                $default_day = Carbon::now()->subMonth()->firstOfMonth()->toDateString();
                break;
            case 'last_month_end':
                $default_day = Carbon::now()->subMonth()->endOfMonth()->toDateString();
                break;
            default :
                $default_day = '';
        }
        return $default_day;
    }
}

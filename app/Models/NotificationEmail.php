<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NotificationEmail extends Model
{

    protected $table = 'notification_emails';
    public $timestamps = false;

    const TPYE = [
        'notice'    => '通告',
        'itsupport' => 'IT求助',
        'repair'    => '維修',
        'claim'     => '醫療索償',
    ];

    public function scopeIsTest($query)
    {
        $is_test = isTestEnvironment();

        return $query->where('is_test', $is_test);
    }

}

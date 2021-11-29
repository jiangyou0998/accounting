<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NotificationEmail extends Model
{

    protected $table = 'notification_emails';
    public $timestamps = false;

    public function scopeIsTest($query)
    {
        $is_test = isTestEnvironment();

        return $query->where('is_test', $is_test);
    }

}

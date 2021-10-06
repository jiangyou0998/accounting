<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $guarded = [];

    public $timestamps = true;

    public static function getEmployees(int $date_before = 0){

        $employees = self::isWorked()->beforeDate($date_before)->get();
        foreach ($employees as $employee){
            $employee->code_and_name = $employee->code . '-' .$employee->name;
        }

        return $employees;
    }

    public function scopeIsWorked($query)
    {
        return $query->where('is_worked', 1);
    }

    public function scopeBeforeDate($query, int $date_before)
    {
        $date = Carbon::today()->subDays($date_before)->toDateString();
        return $query->where('employment_date', '<' , $date);
    }
}

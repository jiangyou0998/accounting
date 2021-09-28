<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $guarded = [];

    public $timestamps = true;

    public static function getEmployees(){

        $employees = self::isWorked()->get();
        foreach ($employees as $employee){
            $employee->code_and_name = $employee->code . '-' .$employee->name;
        }

        return $employees;
    }

    public function scopeIsWorked($query)
    {
        return $query->where('is_worked', 1);
    }
}

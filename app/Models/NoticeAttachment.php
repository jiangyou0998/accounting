<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NoticeAttachment extends Model
{

    protected $table = 'notice_attachment';

    protected $fillable = ['title' , 'file_path'];

}

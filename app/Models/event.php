<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class event extends Model
{
    use SoftDeletes;
    //设置表名
    public $table = 'event';
    //开启自动更新时间戳
    public $timestamps = true;
    //开启软删除
    protected $dates = ['deleted_at'];

    public function photos()
    {
        return $this->hasMany('App\Models\image');
    }
}

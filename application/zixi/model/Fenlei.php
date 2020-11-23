<?php

namespace app\zixi\model;

use think\Model;
use traits\model\SoftDelete;

class Fenlei extends Model
{
    use SoftDelete;
    protected $deleteTime='delete_time';
    public function fg(){
        return $this->hasMany('Guige',"fenid");
    }

    public function fs(){
        return $this->hasMany("Shuxing","fenid");
    }
}

<?php

namespace app\recursion\model;

use think\Model;

class Users extends Model
{
    protected $resultSetType='collection';
    public  function User(){
        return $data=$this->hasMany("UR","u_r.uid","u_id");
    }
}

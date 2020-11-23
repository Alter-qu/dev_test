<?php

namespace app\recursion\model;

use think\Model;

class UR extends Model
{
    protected $resultSetType='collection';
    public  function ur(){
        return $data=$this->hasMany("Role","role.r_id","u_r.uid");
    }
}

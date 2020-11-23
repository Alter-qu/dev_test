<?php

namespace app\recursion\model;

use think\Model;

class Role extends Model
{
    protected $resultSetType='collection';
    function rol(){
        return $data=$this->hasMany('R_p',"r_p.rid","role.r_id");
    }
}

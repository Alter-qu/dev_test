<?php

namespace app\recursion\model;

use think\Model;

class RP extends Model
{
    protected $resultSetType='collection';
    public  function rp(){
        return $data=$this->hasMany("Power","power.p_id","r_p.rid");
    }
}

<?php

namespace app\zixi\model;

use think\Model;
use traits\model\SoftDelete;

class Guige extends Model
{
    use SoftDelete;
    protected $deleteTime='delete_time';
    protected $resultSetType='collection';
    public function gv(){
        return $this->hasMany("Value","guiid","gui_id");
    }
}

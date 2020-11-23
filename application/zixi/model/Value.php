<?php

namespace app\zixi\model;

use think\Model;
use traits\model\SoftDelete;

class Value extends Model
{
    use SoftDelete;
    protected $deleteTime='delete_time';
}

<?php

namespace app\zixi\model;

use think\Model;
use traits\model\SoftDelete;


class Goods extends Model
{
    use SoftDelete;
    protected $deletime='delete_time';
}

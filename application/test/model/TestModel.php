<?php

namespace app\test\model;

use think\Model;

class TestModel extends Model
{
    protected $resultSetType="collection";
    static function login($arr){
        $obj['name']=$arr['name'];
       $res1= self::table('admin')->where('name',$obj['name'])->find();
       if (!$res1){
           return json(['name'=>null]);
       }
        $obj['pwd']=$arr['pwd'];
       return $data=self::table('admin')->where($obj)->find();
    }
}

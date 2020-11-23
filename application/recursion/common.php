<?php
if (!function_exists("recursion")){
    function recursion($data,$pid=0,$level=1){
      static  $arr=[];
        foreach ($data as $key=>$val){
            if ($val['pid']==$pid){
                $val['level']=$level;
                $arr[]=$val;
                recursion($data,$val['p_id'],$level+1);
            }
        }
      return  $arr;
    }
}
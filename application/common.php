<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 验证模型名是否为空
if (!function_exists("fenYan")){
    function fenYan($data){
        if (empty(trim($data['name']))){
            unset($data);
        }
        //验证规格名是否为空
        foreach ($data['guige'] as $key=>$val){
            if (empty(trim($val['gui_name']))){
                unset($data['guige'][$key]);
                continue;
            }
            //验证规格值是否为空，为空的删了，都是空的删本条规格
            foreach($val["value"] as $k=>$v){
                if (empty(trim($v))){
                    unset($data['guige'][$key]['value'][$k]);
                }
            }
            if (empty($data['guige'][$key]['value'])){
                unset($data['guige'][$key]);
            }
        }
        //属性验证
        foreach ($data['shuxing'] as $key=>$val){
            if (empty(trim($val['shu_name']))){
                unset($data['shuxing'][$key]);
            }
            //验证属性的值是否存在，不存在删掉
           foreach ($val['shu_value'] as $k=>$v){
               if (empty(trim($v))){
                   unset($data['shuxing'][$key]['shu_value'][$k]);
               }
           }
            //属性值都不存在，删掉本条属性
            if (empty($data['shuxing'][$key]['shu_value'])){
                unset($data['shuxing'][$key]);
            }
        }
    return $data;
    }
}
//组装规格的录入数据
if (!function_exists("guigeData")){

    function guigeData($res,$id){
        $guigeData=[];
        foreach ($res['guige'] as $key=>$val){
            $guigeData[]=[
              'gui_name'=>$val['gui_name'],
                'fenid'=>$id
            ];
        }
       return $guigeData;
    }
}
//组装规格值的录入数据
if (!function_exists('valData')){

    function valData($data,$guiid,$id){
        $valData=[];
        foreach ($data['guige'] as $key=>$val){
            foreach ($val['value'] as $k=>$v){
                $valData[]=[
                    'v_name'=>$v,
                    "guiid"=>$guiid,
                    "fenid"=>$id
                ];
            }
        }
        return $valData;
    }
}
//组装属性的录入数据
if (!function_exists("shuData")){
    $shuData=[];
    function shuData($data,$id){
        foreach ($data['shuxing'] as $key=>$val){
                $shuData[]=[
                    'shu_name'=>$val['shu_name'],
                    'shu_value'=>implode(",",$val['shu_value']),
                    'fenid'=>$id
                ];

        }
    return $shuData;
    }
}
//商品信息过滤
    if (!function_exists('goodsyan')){
        function goodsyan($data){
            if (empty(trim($data['good_name']))){
                unset($data);
            }
            if (!is_file(".".$data['goods_logo'])){
                unset($data);
            }
            //dirname()返回目录部分
            //basename()返回文件部分
            $logo_path='.'.dirname($data['goods_logo']).DS."thumb_".basename($data['goods_logo']);
            \think\Image::open(".".$data['goods_logo'])->thumb(210,240)->save($logo_path);
            //覆盖原来的路径
            $data['goods_logo']=trim($logo_path,".");
            //处理属性7和8
            $attrs=[];
            foreach ($data['shuxing'] as $key=>$val){
                $attrs[]=$val;
            }
            $data['shuxing']=$attrs;
            //商品属性（存json字符串）
            $data['shu_value']=json_encode($data['shuxing'],JSON_UNESCAPED_UNICODE);
            unset($data['shuxing']);
            return $data;
        }
    }


?>
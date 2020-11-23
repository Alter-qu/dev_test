<?php

namespace app\zixi\controller;

use think\Controller;
use think\Request;

class Goods extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $param = [
            'good_name' => 'iphone X',
            'goods_price' => '8900',
            'goods_introduce' => 'iphone iphonex',
            'goods_logo' => '/uploads/goods/20201113/8708faa02bafefbad024752ebd1f9b2c.jpg',
            'goods_images' => [
                '/uploads/goods/20201113/8708faa02bafefbad024752ebd1f9b2c.jpg',
                '/uploads/goods/20201113/8708faa02bafefbad024752ebd1f9b2c.jpg',
                '/uploads/goods/20201113/8708faa02bafefbad024752ebd1f9b2c.jpg',
                '/uploads/goods/20201113/8708faa02bafefbad024752ebd1f9b2c.jpg'
            ],
            'fenid' => '2',
            'brand_id' => '3',
            'gui_id' => '16',
            'value' => [
                '18_21' => [
                    'value_ids'=>'18_21',
                    'value_names'=>'颜色：黑色；内存：64G',
                    'price'=>'8900.00',
                    'cost_price'=>'5000.00',
                    'store_count'=>100
                ],
                '18_22' => [
                    'value_ids'=>'18_22',
                    'value_names'=>'颜色：黑色；内存：128G',
                    'price'=>'9000.00',
                    'cost_price'=>'5000.00',
                    'store_count'=>50
                ]
            ],
            'shuxing' => [
                '7' => ['id'=>'7', 'attr_name'=>'毛重', 'attr_value'=>'150g'],
                '8' => ['id'=>'8', 'attr_name'=>'产地', 'attr_value'=>'国产'],
            ]
        ];
        //表单验证
        //过滤数组
        $data=goodsyan($param);
        //商品入库
        $goods=\app\zixi\model\Goods::create($data,true);
        //制作相册
        //组装录入数组，分别录入
        //商品录入

        //分类录入

        //规格录入

        //规格值录入

        //属性录入

        //返回数据

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}

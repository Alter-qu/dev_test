<?php

namespace app\zixi\controller;

use app\zixi\model\Fenlei;
use app\zixi\model\Goods;
use app\zixi\model\Guige;
use app\zixi\model\Shuxing;
use app\zixi\model\Value;
use think\Controller;
use think\Request;
use think\Db;

class Zixi extends Controller
{

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

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
       $data=array(
           'name'=>'沙发',
           'guige'=>array(
               array(
                   'gui_name'=>'组合',
                   'value'=>array(
                       '1',
                       '2',
                       '',
                       '4'
                   )
               ),
               array(
                       'gui_name'=>'材质',
                       'value'=>array(
                           '棉布',
                           '真皮'
                       )
               ),
               array(
                           'gui_name'=>'',
                           'value'=>array(
                               '1',
                               '2'
                  )
               )
           ),
           'shuxing'=>array(
                    array(
                        'shu_name'=>'填充物',
                        'shu_value'=>array(
                            '海绵',
                            '海藻',
                            ""
                        )
                    ),
               array(
                   'shu_name'=>'生产地',
                   'shu_value'=>array(
                       '山东',
                       '威海',
                       ""
                   )
               ),
                    array(
                        'shu_name'=>'',
                        'shu_value'=>array(
                            '1',
                            '2'
                        )
                    )
           )
       );
       //过滤所有数据
       $res=fenYan($data);
      //dump($res);
      //事务录入

       Db::startTrans();
        try {
            //录入分类
            $fenlei=Fenlei::create(['name'=>$res['name']])->toArray();
            //取出录入的id
            $id=$fenlei['id'];
            //dump($fenlei);
            //调用封装，录入规格
            $guige=guigeData($res,$id);
            //dump($guige);
            $guigeres=model("Guige")->saveAll($guige)->toArray();
           //dump($guigeres);
            //调用封装，录入规格值
            $guiid=$guigeres[0]['gui_id'];
            //dump($guiid);

            $value=valData($res,$guiid,$id);
           //dump($value);
            model("Value")->saveAll($value);
            //调用封装，录入属性
            $shuxing=shuData($res,$id);
            //dump($shuxing);
           $re= model('Shuxing')->saveAll($shuxing)->toArray();
           //dump($re);
            Db::commit();
            return json(['code'=>200,'msg'=>'ok','result'=>null]);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        if(!is_numeric($id)){
            return json(['code'=>403,'msg'=>'fail','result'=>"参数格式不正确"]);
        }
        //查询分类下的分类信息
        $data=Fenlei::with("fg,fg.gv,fs")->find($id);
        if ($data){
            return json(['code'=>200,'msg'=>'ok','result'=>$data]);
        }else{
            return json(['code'=>200,'msg'=>'fail','result'=>null]);

        }

    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
       $data= Fenlei::where('id',$id)->select();
       return view("",['data'=>$data]);
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
        //接收数据，检测数据
//        $data=$request->param();
        $data=array(
            'name'=>'冰箱',
            'guige'=>array(
                array(
                    'gui_name'=>'温差',
                    'value'=>array(
                        '1',
                        '2',
                        '',
                        '4'
                    )
                ),
                array(
                    'gui_name'=>'外壳',
                    'value'=>array(
                        '棉布',
                        '真皮'
                    )
                ),
                array(
                    'gui_name'=>'',
                    'value'=>array(
                        '1',
                        '2'
                    )
                )
            ),
            'shuxing'=>array(
                array(
                    'shu_name'=>'型号',
                    'shu_value'=>array(
                        '海绵',
                        '海藻',
                        ""
                    )
                ),
                array(
                    'shu_name'=>'发源地',
                    'shu_value'=>array(
                        '山东',
                        '威海',
                        ""
                    )
                ),
                array(
                    'shu_name'=>'',
                    'shu_value'=>array(
                        '1',
                        '2'
                    )
                )
            )
        );
       //处理过滤数据，形成录入的数据
        $filtration=fenYan($data);
        //规格的录入数据
        $guigeData=guigeData($filtration,$id);
        //开启事务
        Db::startTrans();
        try {
            //修改模型数据
            $fenlei=Fenlei::update(['name'=>$data['name']],['id'=>$id]);
            //删除规格
            Guige::destroy(['fenid'=>$id]);
            //存入规格
            $guige=model('Guige')->saveAll($guigeData);
            //提取规格数据，制作规格值录入数据
            $guigeID=$guige[0]['gui_id'];
            $value=valData($filtration,$guigeID,$id);
            //删除规格值,存入新数据
            Value::destroy(['fenid'=>$id]);
            model('value')->saveAll($value);
            //制作属性数据
            $shudata=shuData($filtration,$id);
            //删除属性，录入新的
            Shuxing::destroy(['fenid'=>$id]);
            model('shuxing')->saveAll($shudata);
            Db::commit();
            return json(['code'=>200,'msg'=>'ok','result'=>null]);
        }catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */

    public function delete($id)
    {
        if (!is_numeric($id)){
            $this->error("参数不正确");
        }
        $data=Goods::where("fenid",$id)->select();
        if ($data){
            return json(["code"=>403,'msg'=>'分类下有商品不可删除','result'=>$data]);
        }
        // 启动事务
        Db::startTrans();
        try{
          Fenlei::destroy($id);
          Guige::destroy(['fenid'=>$id]);
          Shuxing::destroy(['fenid'=>$id]);
          Value::destroy(['fenid'=>$id]);
            // 提交事务
            Db::commit();
            return json(["code"=>200,'msg'=>'ok','result'=>null]);

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return json(["code"=>403,'msg'=>'稍后再试','result'=>null]);

        }


    }
}

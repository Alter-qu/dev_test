<?php

namespace app\test\controller;

use app\test\model\TestModel;
use think\Controller;
use think\Request;
use think\Session;

header("Access-Control-Allow-Origin:*");
class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function login(Request $request)
    {
        $data=$request->param();
        //dump($data);
     $res=TestModel::login($data);
     //dump($res);
        if ($res['name']=null){
            return ['code'=>404,"msg"=>"fail","result"=>"用户不存在"];
        }elseif($res!=false){
           // $res->toArray();
            Session::start();
            \session("u_id",$res['u_id']);
            return json(['code'=>200,"msg"=>"sucess","result"=>"$res"]);
        }else{
            return json(['code'=>403,"msg"=>"fail","result"=>"密码错误"]);
        }

    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function show()
    {
        return view("show");
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

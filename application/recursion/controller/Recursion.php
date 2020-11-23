<?php

namespace app\recursion\controller;

use app\recursion\model\Users;
use think\Controller;
use think\Db;
use think\Request;

class Recursion extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=Db::table('u_r')
            ->join('r_p',"u_r.rid=r_p.rid")
            ->join('power',"r_p.pid=power.p_id")
            ->where('uid',1)
            ->select();
       //print_r($data);

        $res=recursion($data);
       print_r($res);
        return view('',['list'=>$res]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {

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
    public function read()
    {
        $data=Users::with('User')->select();
        dump($data);
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

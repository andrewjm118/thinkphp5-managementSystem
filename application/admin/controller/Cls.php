<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\CourseInfo;
class Cls extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->cls = new CourseInfo();
    }
    //课程列表
    public function clslist(){
        $result = $this->cls -> select();
        return view('clslist',['result'=>$result]);
    }
    //添加课程
    public function clsadd(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->cls -> add($params); 
            if ($result) {
                return json(['code'=>200,'msg'=>'添加成功']);
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            return view();    
        }
    }
    //编辑课程
    public function clsedit(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->cls -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $clsdetail = $this->cls->where('cid',input('cid'))->find();
            return view('clsedit',['clsdetail'=>$clsdetail]);
        }
    }
    //删除课程
    public function clsdel(){
        $result = $this->cls->destroy(input('post.cid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }


}
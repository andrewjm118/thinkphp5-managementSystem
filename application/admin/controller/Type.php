<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\TypeInfo;
class Type extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new TypeInfo();
    }
    //课程列表
    public function typelist(){
        $result = $this->model -> select();
        return view('typelist',['result'=>$result]);
    }
    //添加课程
    public function typeadd(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->model -> add($params); 
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
    public function typeedit(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->model -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $typedetail = $this->model->where('ti_id',input('ti_id'))->find();
            return view('typeedit',['typedetail'=>$typedetail]);
        }
    }
    //删除课程
    public function typedel(){
        $result = $this->model->destroy(input('post.ti_id'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }


}
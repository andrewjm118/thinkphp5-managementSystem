<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\TypeVal;
use app\admin\model\TypeInfo;
class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new TypeVal();
        $this->typeinfo = new TypeInfo();
    }
    //基础数据列表
    public function baselist(){
        $result = $this->model
        ->alias('b')
        ->join('__TYPE_INFO__ t','b.ti_id=t.ti_id')
        ->select();
        return view('baselist',['result'=>$result]);
    }
    //添加基础数据
    public function baseadd(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->model -> add($params); 
            if ($result) {
                return json(['code'=>200,'msg'=>'添加成功']);
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            $leixing = $this->typeinfo->select();
            return view('baseadd',['leixing'=>$leixing]);    
        }
    }
    //编辑基础数据
    public function baseedit(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->model -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $basedetail = $this->model
            ->alias('b')
            ->join('__TYPE_INFO__ t','b.ti_id=t.ti_id')
            ->where('tv_id',input('tv_id'))
            ->find();
            $leixing = $this->typeinfo->select();
            return view('baseedit',['basedetail'=>$basedetail,'leixing'=>$leixing]);
        }
    }
    //删除基础数据
    public function basedel(){
        $result = $this->model->destroy(input('post.tv_id'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }


}
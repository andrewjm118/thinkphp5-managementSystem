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
use app\admin\model\StuInfo;
use app\admin\model\TypeVal;
class Cou extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new CourseInfo();
        $this->stu = new StuInfo();
        $this->typeval = new TypeVal();

    }
    //交费列表
    public function coulist(){
        $params = input('param.');
        $order = 'cid desc';
        $search ='';
        if(!empty($params['search']) && is_array($params['search'])){
            foreach ($params['search'] as $k => $v) {
                if($v){
                    $search[$k] = array('like','%'.$v.'%'); 
                }
            }
        }
        $page_size =!empty($params['page_size'])?$params['page_size']:'';
        $url_params =!empty(parse_url(request()->url(true))['query'])?parse_url(request()->url(true))['query']:'';
        $paylist = $this->model->get_list($search,$order,$page_size);
        return view('coulist',['result'=>$paylist['data'],'total'=>$paylist['total'],'per_page'=>$paylist['per_page'],'current_page'=>$paylist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //添加交费
    public function couadd(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->model -> add($params); 
            if ($result) {
                return json(['code'=>200,'msg'=>'添加成功']);
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            $kemu = $this->typeval->where('ti_id',5)->select();
            $kelei = $this->typeval->where('ti_id',9)->select();
            $grade = $this->typeval->where('ti_id',7)->select();
            return view('couadd',['kelei'=>$kelei,'grade'=>$grade,'kemu'=>$kemu]);    
        }
    }
    //编辑课程
    public function couedit(){
        if (request()->isPost()) {
            $params = input('post.');
            $result = $this->model -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $paydetail = $this->model->where('cid',input('cid'))->find();
            $kemu = $this->typeval->where('ti_id',5)->select();
            $kelei = $this->typeval->where('ti_id',9)->select();
            $grade = $this->typeval->where('ti_id',7)->select();
            return view('couedit',['paydetail'=>$paydetail,'kelei'=>$kelei,'grade'=>$grade,'kemu'=>$kemu]);
        }
    }
    //删除课程
    public function coudel(){
        $result = $this->model->destroy(input('post.cid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['cid']);
        $result = $this->model->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }


}
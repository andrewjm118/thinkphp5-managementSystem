<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\Logs;
class Rizhi extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->logs = new Logs();
    }
    //错题列表
    public function rizhilist(){
        $params = input('param.');
        $order = 'id desc';
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
        $errorlist = $this->logs ->get_list($search,$order,$page_size);
        return view('rizhilist',['result'=>$errorlist['data'],'total'=>$errorlist['total'],'per_page'=>$errorlist['per_page'],'current_page'=>$errorlist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //删除错题
    public function rizhidel(){
        $result = $this->logs->destroy(input('post.id'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['id']);
        $result = $this->logs->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }

}
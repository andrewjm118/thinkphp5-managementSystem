<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\TeacherInfo;
use app\admin\model\AuthGroup;
use app\admin\model\TypeVal;
class Tch extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $this->typeval = new TypeVal();

    }
    //教师列表
    public function tchlist(){
        $params = input('param.');
        $order = 'sort asc';
        $search ='';
        if(!empty($params['search']) && is_array($params['search'])){
            foreach ($params['search'] as $k => $v) {
                if($v){
                    $search[$k] = array('like','%'.$v.'%'); 
                }
            }
        }
        $page_size =!empty($params['page_size'])?$params['page_size']:'';
        $tch = new TeacherInfo();
        $url_params =!empty(parse_url(request()->url(true))['query'])?parse_url(request()->url(true))['query']:'';
        $tchlist = $tch->get_list($search,$order,$page_size);
        return view('tchlist',['result'=>$tchlist['data'],'total'=>$tchlist['total'],'per_page'=>$tchlist['per_page'],'current_page'=>$tchlist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //添加教师
    public function tchadd(){
        if (request()->isPost()) {
            $params = input('post.');
            $tch = new TeacherInfo();
            $result = $tch -> add($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'添加成功']); 
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            $auth = new AuthGroup();
            $authlist = $auth->select();
            $kemu = $this->typeval->where('ti_id',5)->select();
            return view('tchadd',['authlist'=>$authlist,'kemu'=>$kemu]);
        }
    }
    //编辑教师
    public function tchedit(){
        if (request()->isPost()) {
            $params = input('post.');
            $tch = new TeacherInfo();
            $result = $tch -> edit($params);

            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功','sql'=>$tch->getLastSql()]);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $tch = new TeacherInfo();
            $tchdetail = $tch->where('tid',input('tid'))->find();
            $auth = new AuthGroup();
            $authlist = $auth->select();
            $kemu = $this->typeval->where('ti_id',5)->select();
            return view('tchedit',['tchdetail'=>$tchdetail,'authlist'=>$authlist,'kemu'=>$kemu]);
        }
    }
    //删除教师
    public function tchdel(){
        $tch = new TeacherInfo();
        $result = $tch->destroy(input('post.tid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['tid']);
        $tch = new TeacherInfo();
        $result = $tch->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }
    //检查手机号是否存在
    public function getphone(){
        $tch = new TeacherInfo();
        $is_phone = $tch->where('tphone',input('post.phone'))->find();
        if($is_phone){
            return json(array('code'=>200,'msg'=>'手机号已存在'));
        }else{
            return json(array('code'=>0,'msg'=>'手机号不存在'));
        }
    }
    //上传图片
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $path = '/uploads/'.$info->getSaveName();
            return json(['code'=>0,'msg'=>'上传成功','data'=>['src'=>$path]]);
        }else{
            return json(['code'=>200,'msg'=>'上传失败']);
        }
    }


    //排序
    public function sort(){
        $params = input('get.');
        $tch = new TeacherInfo();
        $sort = $tch->sort($params);
        if($sort){
            return json(array('status'=>200,'msg'=>'更新成功','url'=>'reload'));
        }else{
            return json(array('status'=>202,'msg'=>'更新失败','url'=>'reload'));
        }

    }

}

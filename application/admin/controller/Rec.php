<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\RecordInfo;
use app\admin\model\StuInfo;
use app\admin\model\TypeVal;
use app\admin\model\TeacherInfo;
use app\admin\model\CourseInfo;
use app\admin\model\PayInfo;
use app\admin\model\User;
class Rec extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new RecordInfo();
        $this->stu = new StuInfo();
        $this->typeval = new TypeVal();
        $this->tch = new TeacherInfo();
        $this->cou = new CourseInfo();
        $this->pay = new PayInfo();
        $this->user = new User();
    }
    //上课纪录列表
    public function reclist(){
        $params = input('param.');
        $order = 'rid desc';
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
        return view('reclist',['result'=>$paylist['data'],'total'=>$paylist['total'],'per_page'=>$paylist['per_page'],'current_page'=>$paylist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //老师上课纪录列表
    public function teaReclist(){
        $params = input('param.');
        $order = 'rid desc';
        $search ='';
        if(!empty($params['search']) && is_array($params['search'])){
            foreach ($params['search'] as $k => $v) {
                if($v){
                    $search[$k] = array('like','%'.$v.'%'); 
                }
            }
        }
        //获取该老师添加的错题
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        $search['rtid'] = $userdt['teacher_id'];
        //获取该老师添加的错题
        $page_size =!empty($params['page_size'])?$params['page_size']:'';
        $url_params =!empty(parse_url(request()->url(true))['query'])?parse_url(request()->url(true))['query']:'';
        $paylist = $this->model->get_list($search,$order,$page_size);
        return view('teaReclist',['result'=>$paylist['data'],'total'=>$paylist['total'],'per_page'=>$paylist['per_page'],'current_page'=>$paylist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //添加纪录
    public function recadd(){
        if (request()->isPost()) {
            $params = input('post.');
            if (!empty($params['rstu'])) {
                $tarr = explode('|',$params['rstu']);
                $params['rstu'] = $tarr[0];
                $params['stuid'] = $tarr[1];
            } else {
                $params['rstu'] = '';
                $params['stuid'] = '';
            }
            $params['rdiscount'] = round(($params['rincome']/$params['rprice'])*100).'%';//折扣
            $rid = $this->model -> add($params); 
            if ($rid) {
                return json(['code'=>200,'msg'=>'添加成功']);        
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            $stulist = $this->stu->select();
            $tchlist = $this->tch->select();
            $kecheng = $this->cou->select();
            return view('recadd',['stulist'=>$stulist,'tchlist'=>$tchlist,'kecheng'=>$kecheng]);    
        }
    }
    //老师添加纪录
    public function teaRecadd(){
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        if (request()->isPost()) {
            $params = input('post.');
            //获取当前登录老师信息
            $teadt = $this->tch->get_teadt($userdt['teacher_id']);
            if ($teadt) {
                $params['rteacher'] = $teadt['tname'];
                $params['rtid'] = $teadt['tid'];
            }
            if (!empty($params['rstu'])) {
                $tarr = explode('|',$params['rstu']);
                $params['rstu'] = $tarr[0];
                $params['stuid'] = $tarr[1];
            } else {
                $params['rstu'] = '';
                $params['stuid'] = '';
            }
            $params['rdiscount'] = round(($params['rincome']/$params['rprice'])*100).'%';//折扣
            $rid = $this->model -> add($params); 
            if ($rid) {
                return json(['code'=>200,'msg'=>'添加成功']);        
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            //获取当前登录老师的学生
            if ($userdt) {
                $stulist = $this->stu->get_stus($userdt['stus']);
            } else {
                $stulist = '';
            }
            //获取当前登录老师的学生
            $kecheng = $this->cou->select();
            return view('teaRecadd',['stulist'=>$stulist,'kecheng'=>$kecheng]);    
        }
    }
    //判断是否缴过费
    public function getyu(){
        $params = input('post.');
        if (!empty($params['rstu'])) {
            $tarr = explode('|',$params['rstu']);
            $params['rstu'] = $tarr[0];
            $params['stuid'] = $tarr[1];
        } else {
            $params['rstu'] = '';
            $params['stuid'] = '';
        }
        $is_yu = $this->pay->get_is_yu($params['rstu']);
        if ($is_yu !== false) {
            return json(['code'=>200,'msg'=>'该学员缴过费']);
        } else {
            return json(['code'=>0,'msg'=>'该学员还没有缴过费']);
        }
    }
    //编辑纪录
    public function recedit(){
        if (request()->isPost()) {
            $params = input('post.');
            if (!empty($params['rstu'])) {
                $tarr = explode('|',$params['rstu']);
                $params['rstu'] = $tarr[0];
                $params['stuid'] = $tarr[1];
            } else {
                $params['rstu'] = '';
                $params['stuid'] = '';
            }
            $params['rdiscount'] = round(($params['rincome']/$params['rprice'])*100).'%';
            $result = $this->model -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $stulist = $this->stu->select();
            $tchlist = $this->tch->select();
            $kecheng = $this->cou->select();
            $paydetail = $this->model->where('rid',input('rid'))->find();
            return view('recedit',['paydetail'=>$paydetail,'stulist'=>$stulist,'tchlist'=>$tchlist,'kecheng'=>$kecheng]);
        }
    }
    //老师编辑纪录
    public function teaRecedit(){
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        if (request()->isPost()) {
            $params = input('post.');
            //获取当前登录老师信息
            $teadt = $this->tch->get_teadt($userdt['teacher_id']);
            if ($teadt) {
                $params['rteacher'] = $teadt['tname'];
                $params['rtid'] = $teadt['tid'];
            }
            if (!empty($params['rstu'])) {
                $tarr = explode('|',$params['rstu']);
                $params['rstu'] = $tarr[0];
                $params['stuid'] = $tarr[1];
            } else {
                $params['rstu'] = '';
                $params['stuid'] = '';
            }
            $params['rdiscount'] = round(($params['rincome']/$params['rprice'])*100).'%';//折扣
            $result = $this->model -> edit($params); 
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            //获取当前登录老师的学生
            if ($userdt) {
                $stulist = $this->stu->get_stus($userdt['stus']);
            } else {
                $stulist = '';
            }
            //获取当前登录老师的学生
            $kecheng = $this->cou->select();
            $paydetail = $this->model->where('rid',input('rid'))->find();
            return view('teaRecedit',['paydetail'=>$paydetail,'stulist'=>$stulist,'kecheng'=>$kecheng]);    
        }
    }
    //删除课程
    public function recdel(){
        $result = $this->model->destroy(input('post.rid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['rid']);
        $result = $this->model->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }
    //获取下拉所选课程价钱
    public function getcou(){
        $cid = input('post.cid');
        $result = $this->cou->where('cid',$cid)->find();
        if($result){
            return json(array('code'=>200,'msg'=>'查询成功','result'=>$result));
        }else{
            return json(array('code'=>0,'msg'=>'查询失败'));
        }
    }
    //上传图片
    public function uploads(){
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


}
<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use app\admin\model\StuInfo;
use app\admin\model\TypeVal;
use app\admin\model\TeacherInfo;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
class Users extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->user = new User();
        $this->stu = new StuInfo();
        $this->typeval = new TypeVal();
        $this->tch = new TeacherInfo();
        $this->auth = new AuthGroup();
        $this->aga = new AuthGroupAccess();
    }
    //错题列表
    public function userlist(){
        $params = input('param.');
        $order = 'uid desc';
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
        $errorlist = $this->user ->get_list($search,$order,$page_size);
        return view('userlist',['result'=>$errorlist['data'],'total'=>$errorlist['total'],'per_page'=>$errorlist['per_page'],'current_page'=>$errorlist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //添加人员
    public function useradd(){
        if (request()->isPost()) {
            $params = input('post.');
            if (!empty($params['stus'])) {
                $params['stus'] = implode(",",$params['stus']);
            } else {
                $params['stus'] = '';
            }
            if(empty($params['lock'])){
                $params['lock'] = 0;
            }else{
                $params['lock'] = 1;
            }
            $params['pass'] = waimao_ucenter_md5($params['pass']);
            if (!empty($params['teacher_id'])) {
                $tarr = explode('|',$params['teacher_id']);
                $params['teacher_id'] = $tarr[0];
                $params['nick'] = $tarr[1];
            } else {
                $params['teacher_id'] = '';
                $params['nick'] = '';
            }
            $aarr = explode('|',$params['rule_id']);
            $params['rule_id'] = $aarr[0];
            $params['rule_name'] = $aarr[1];
            $uid = $this->user -> add($params);
            if ($uid) {
                $agas['uid'] = $uid;
                $agas['group_id'] = $params['rule_id'];
                $result = $this->aga -> add($agas);
                if ($result) {
                    $tch['tid'] = $params['teacher_id'];
                    $tch['is_sign'] = 1;
                    $teacher = $this->tch->edit($tch);
                    if($teacher){
                        return json(['code'=>200,'msg'=>'添加成功']);
                    }else{
                        //
                    }
                }else {
                    return json(['code'=>0,'msg'=>'添加组失败']);
                }
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            $authlist = $this->auth->select();
            //查询未添加的教师
            $tid = $this->user->column('teacher_id');
            $tchlist = $this->tch->get_u_tea($tid);//获取未分配角色的老师
            //学生列表
            $stulist = $this->stu->select();
            return view('useradd',['authlist'=>$authlist,'tchlist'=>$tchlist,'stulist'=>$stulist]);
        }
    }
    //编辑人员
    public function useredit(){
        if (request()->isPost()) {
            $params = input('post.');
            if (!empty($params['stus'])) {
                $params['stus'] = implode(",",$params['stus']);
            } else {
                $params['stus'] = '';
            }
            if(empty($params['lock'])){
                $params['lock'] = 0;
            }else{
                $params['lock'] = 1;
            }
            if(empty(trim($params['pass']))){
                unset($params['pass']);
            } else {
                $params['pass'] = waimao_ucenter_md5($params['pass']);
            }
            if (!empty($params['teacher_id'])) {
                $tarr = explode('|',$params['teacher_id']);
                $params['teacher_id'] = $tarr[0];
                $params['nick'] = $tarr[1];
            } else {
                $params['teacher_id'] = '';
               // $params['nick'] = '';
            }
            $aarr = explode('|',$params['rule_id']);
            $params['rule_id'] = $aarr[0];
            $params['rule_name'] = $aarr[1];
            $result = $this->user -> edit($params);
            if ($result) {
                $upds = $this->aga->upd($params['uid'],$params['rule_id']);
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败','result' => $result]);
            }
        } else {
            $userdetail = $this->user->where('uid',input('param.uid'))->find();
            $authlist = $this->auth->select();
            //查询未添加的教师
            $tid = $this->user->column('teacher_id');
            $tids = $this->array_remove($tid,$userdetail['teacher_id']);
            $tchlist = $this->tch->get_u_tea($tids);//获取未分配角色的老师
            //学生列表
            $stulist = $this->stu->select();
            return view('useredit',['authlist'=>$authlist,'tchlist'=>$tchlist,'userdetail'=>$userdetail,'stulist'=>$stulist]);
        }
    }
    //从数组中移除某键值元素
    public function array_remove($arr, $key){ 
        if(!in_array($key, $arr)){ 
            return $arr; 
        } 
        $index = array_search($key, $arr); 
        if($index !== FALSE){ 
            array_splice($arr, $index, 1); 
        } 
        return $arr; 
    } 
    //删除错题
    public function userdel(){
        $result = $this->user->destroy(input('post.uid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['uid']);
        $result = $this->user->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }

}
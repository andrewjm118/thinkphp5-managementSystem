<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\ErrortestInfo;
use app\admin\model\StuInfo;
use app\admin\model\TypeVal;
use app\admin\model\TeacherInfo;
use app\admin\model\User;
use think\Db;
class Error extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->error = new ErrortestInfo();
        $this->stu = new StuInfo();
        $this->typeval = new TypeVal();
        $this->tch = new TeacherInfo();
        $this->user = new User();
    }
    //错题列表
    public function errorlist(){
        $params = input('param.');
        $order = 'etid desc';
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
        $errorlist = $this->error ->get_list($search,$order,$page_size);
        return view('errorlist',['result'=>$errorlist['data'],'total'=>$errorlist['total'],'per_page'=>$errorlist['per_page'],'current_page'=>$errorlist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //老师错题列表
    public function teaErrorlist(){
        $params = input('param.');
        $order = 'etid desc';
        $search ='';
        if(!empty($params['search']) && is_array($params['search'])){
            foreach ($params['search'] as $k => $v) {
                if($v){
                    if($k == "ettime"){
                        $search[$k] = array('=',$v);
                    }else{
                        $search[$k] = array('like','%'.$v.'%');
                    }

                }
            }
        }
        //获取该老师添加的错题
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        $search['teaid'] = $userdt['teacher_id'];
        //获取该老师添加的错题
        $page_size =!empty($params['page_size'])?$params['page_size']:'';
        $url_params =!empty(parse_url(request()->url(true))['query'])?parse_url(request()->url(true))['query']:'';
        $errorlist = $this->error ->get_list($search,$order,$page_size);
        return view('teaErrorlist',['result'=>$errorlist['data'],'total'=>$errorlist['total'],'per_page'=>$errorlist['per_page'],'current_page'=>$errorlist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //添加错题
    public function erroradd(){
        if (request()->isPost()) {
            $params = input('post.');
            if (!empty($params['tu_ids'])) {
                $params['tu_ids'] = implode(",",$params['tu_ids']);
            } else {
                $params['tu_ids'] = '';
            }
            $result = $this->error -> add($params);

            if ($result) {
                return json(['code'=>200,'msg'=>'添加成功']);
            } else {
                return json(['code'=>0,'msg'=>'添加失败']);
            }
        } else {
            $stulist = $this->stu->select();
            $tchlist = $this->tch->select();
            $subject = $this->typeval->where('ti_id',5)->select();
            $errorlist = $this->typeval->where('ti_id',7)->select();
            return view('erroradd',['stulist'=>$stulist,'subject'=>$subject,'tchlist'=>$tchlist,'errorlist'=>$errorlist]);
        }
    }
    //老师添加错题
    public function teaErroradd(){
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        if (request()->isPost()) {
            $params = input('post.');
            //获取当前登录老师信息
            $teadt = $this->tch->get_teadt($userdt['teacher_id']);
            if ($teadt) {
                $params['etteacher'] = $teadt['tname'];
                $params['teaid'] = $teadt['tid'];
            }
            if (!empty($params['etstu'])) {
                $tarr = explode('|',$params['etstu']);
                $params['etstu'] = $tarr[0];
                $params['stuid'] = $tarr[1];
            } else {
                $params['etstu'] = '';
                $params['stuid'] = '';
            }
            if (!empty($params['tu_ids'])) {
                $params['tu_ids'] = implode(",",$params['tu_ids']);
            } else {
                $params['tu_ids'] = '';
            }
            $result = $this->error -> add($params); 
            if ($result) {
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
            // $subject = $this->typeval->where('ti_id',5)->select();
            //获取当前登陆老师的科目
            $tchid =  $this->user->get_tchid($user_auth['uid']);
            $tch = $this->tch->get_teadt($tchid['teacher_id']);
            $errorlist = $this->typeval->where('ti_id',7)->select();
            return view('teaErroradd',['stulist'=>$stulist,'errorlist'=>$errorlist,'tch'=>$tch['kemu']]);
        }
    }
    //上传图片
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $path = $info->getSaveName();
            return json(['code'=>200,'msg'=>'上传成功','path'=>$path]);
        }else{
            return json(['code'=>0,'msg'=>'上传失败']);
        }
    }
    //编辑错题
    public function erroredit(){
        if (request()->isPost()) {
            $params = input('post.');
            if (!empty($params['tu_ids'])) {
                $params['tu_ids'] = implode(",",$params['tu_ids']);
            } else {
                $params['tu_ids'] = '';
            }
            $result = $this->error -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $stulist = $this->stu->select();
            $tchlist = $this->tch->select();
            $subject = $this->typeval->where('ti_id',5)->select();
            $errorlist = $this->typeval->where('ti_id',7)->select();
            $errordetail = $this->error->where('etid',input('etid'))->find();
            return view('erroredit',['errordetail'=>$errordetail,'stulist'=>$stulist,'subject'=>$subject,'tchlist'=>$tchlist,'errorlist'=>$errorlist]);
        }
    }
    //老师编辑错题
    public function teaErroredit(){
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        if (request()->isPost()) {
            $params = input('post.');
            //获取当前登录老师信息
            $teadt = $this->tch->get_teadt($userdt['teacher_id']);
            if ($teadt) {
                $params['etteacher'] = $teadt['tname'];
                $params['teaid'] = $teadt['tid'];
            }
            if (!empty($params['etstu'])) {
                $tarr = explode('|',$params['etstu']);
                $params['etstu'] = $tarr[0];
                $params['stuid'] = $tarr[1];
            } else {
                $params['etstu'] = '';
                $params['stuid'] = '';
            }
            if (!empty($params['tu_ids'])) {
                $params['tu_ids'] = implode(",",$params['tu_ids']);
            } else {
                $params['tu_ids'] = '';
            }
            $result = $this->error -> edit($params); 
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
            $subject = $this->typeval->where('ti_id',5)->select();

            //获取当前登陆老师的科目
            $tchid =  $this->user->get_tchid($user_auth['uid']);
            $tch = $this->tch->get_teadt($tchid['teacher_id']);
            $errorlist = $this->typeval->where('ti_id',7)->select();
            $errordetail = $this->error->where('etid',input('etid'))->find();
            return view('teaErroredit',['errordetail'=>$errordetail,'stulist'=>$stulist,'subject'=>$subject,'errorlist'=>$errorlist,'tch'=>$tch['kemu']]);
        }
    }
    //删除错题
    public function errordel(){
        $result = $this->error->destroy(input('post.etid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['etid']);
        $result = $this->error->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }
    //百度插件上传图片
    public function uploads(){
        if(request()->isPost()){
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $path = '/uploads/'.$info->getSaveName();
                return json(['code'=>200,'msg'=>'上传成功','data'=>['src'=>$path]]);
            }else{
                return json(['code'=>202,'msg'=>'上传失败']);
            }
        }else{
           return 1;
        }

    }

     //编辑错题获取详情
    public function details(){

        if(request()->isGet()){
            $params = input('get.');
            $result = $this->error->details($params['etid']);
            if(!empty($result['tu_ids'])){
                $tulist =  Db::name('tu')->where('tu_id' ,'in',$result['tu_ids'])->select();
                return json(['code'=>200,'msg'=>'有数据','tulist'=>$tulist]);
            }else{
                return json(['code'=>202,'msg'=>'无数据']);
            }
        }else{
            return 1;
        }
    }


    //学生错题统计
    public function stuTongji()
    {
        $params = input('param.');
        $order = 'etid desc';
        $search = '';
        $linshi = '';
        if (!empty($params['search']) && is_array($params['search'])) {
            foreach ($params['search'] as $k => $v) {
                if ($v) {
                    if ($k == "etstu") {
                        $search[$k] = array('like', '%' . $v . '%');
                    } else {
                        $linshi[$k] = $v;
                    }

                }
            }
            if (isset($linshi['start_time']) && isset($linshi['end_time'])) {
                if (dateBDate($linshi['end_time'], $linshi['start_time'])) {
                    $search['ettime'] = array('between time', [$linshi['start_time'], $linshi['end_time']]);
                }
            }


    }

        //获取该老师添加的错题
        $user_auth = session('user_auth');
        $userdt = $this->user->get_userdt($user_auth['uid']);
        $search['teaid'] = $userdt['teacher_id'];

        //获取当前登录老师的学生
        if ($userdt) {
            $stulist = $this->stu->get_stus($userdt['stus']);
        } else {
            $stulist = '';
        }

        //获取该老师添加的错题
        $page_size =!empty($params['page_size'])?$params['page_size']:'';
        $url_params =!empty(parse_url(request()->url(true))['query'])?parse_url(request()->url(true))['query']:'';
        $errorlist = $this->error ->get_list($search,$order,$page_size);
        return view('',['result'=>$errorlist['data'],'total'=>$errorlist['total'],'per_page'=>$errorlist['per_page'],'current_page'=>$errorlist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params,'stulist'=>$stulist]);
    }

    //学生错题查看
    public function stuCha(){
        $errordetail = $this->error->where('etid',input('etid'))->find();
        $result = $this->error->details(input('etid'));
       // $tulist = [];
        if(!empty($result['tu_ids'])){
            $tulist = Db::name('tu')->where('tu_id' ,'in',$result['tu_ids'])->select();
        }else{
            $tulist ='';
        }
        return view('stucha',['errordetail'=>$errordetail,'tu'=>$tulist]);
    }

}
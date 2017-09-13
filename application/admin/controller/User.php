<?php
/*///**
// * Created by PhpStorm.
// * User: andrewjm
// * Date: 2017/5/11
// * Time: 16:07
// */
//
namespace app\admin\controller;
use think\Db;
use think\Session;
use think\Cache;
use app\admin\model\Logs;

class User
{
    use\traits\controller\Jump;
    public function ceshi(){
        $data = Db::table('cuoti_user')->where('mobile','13352516135')->find();
        dump($data);
//        Db::table('user')->find(1);
//        Db::table('user')->where('id', 1)->save(['name' => 'thinkphp']);
//        Db::table('user')->delete(1);
    }


    //登陆用户
    public function login($phone = '', $password = ''){
        if(request()->isPost()){
            $user = Db::table('cuoti_user')->where('mobile',$phone)->find();
            if(is_array($user) && $user['lock']){
                $xin_pass = waimao_ucenter_md5($password);
                if($xin_pass === $user['pass']){
                    $this->update_login($user);         //更新用户登录信息
                    //Cache::clear("menu_cache");   //清除菜单缓存
                    Cache::set('menu_cache', null);  //清除菜单缓存
                    return json(['code'=>200,'msg'=>'登陆成功']);
                } else {
                    return json(['code'=>202,'msg'=>'密码错误']);
                }
            }else{
                return json(['code'=>505,'msg'=>'用户不存在或被禁用']); //用户不存在或被禁用
            }

        }else{
            if(is_login()){
                $this->redirect('/admin/index');
            }else{
                return view();
            }
        }
    }


    //写入登陆日志
    protected function write_log($user)
    {
        $data = array(
            'login_people' => $user['nick'],
            'login_time' => request()->time(),
            'login_ip' => get_client_ip(1),
            'login_auth' => $user['rule_name'],
        );
        $log = new Logs();
        $log->add($data);
    }


    /**
     * 更新登陆信息
     * @param int $id
     */
    protected function update_login($user){
        $data = array(
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => request()->time(),
            'last_login_ip'   => get_client_ip(1),
        );
        Db::table('cuoti_user')->where('uid',$user['uid'])->update($data);


        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             =>$user['uid'],
            'rule_id'             =>$user['rule_id'],
            'rule_name'             =>$user['rule_name'],
            'mobile'        => $user['mobile'],
            'last_login_time' => $user['last_login_time'],
        );

        Session::set('user_auth',$auth);
        Session::set('user_auth_sign',data_auth_sign($auth));

        $this->write_log($user);

    }

    /**
     * 注销登陆
     */
    public  function logout()
    {

        $val = is_login();
        if (is_login()) {
            logout();
            session('[destroy]');
            $this->redirect('/login');
            //redirect('/login','301');
        } else {
            //redirect('/login','301');
            $this->redirect('/login');
        }
    }

    //修改个人密码
    public function  chpwd(){
        if(is_login()){
            if(request()->post()){
                $params = input('post.');
                $user_auth = Session::get('user_auth');
                $uid =$user_auth['uid'];
                $data = array(
                    'pass' => waimao_ucenter_md5($params['pass']),
                );
               $result =  Db::table('cuoti_user')->where('uid',$uid)->update($data);
               if($result !== false){
                   return json(['code'=>200,'msg'=>'密码修改成功']);
               }else{
                   return json(['code'=>202,'msg'=>'未知错误,联系管理员']);
               }
            }else{
                return view();
            }
        }else{
            $this->redirect('/login');
        }

    }

}
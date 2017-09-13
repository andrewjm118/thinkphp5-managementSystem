<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/5/11
 * Time: 12:27
 */

namespace app\admin\controller;
use com\Auth;
use think\Controller;
use think\Loader;

class Common extends Controller
{
    public function _initialize(){
       /*Loader::import('org\Auth', EXTEND_PATH);
       $auth = new Auth();
       //第一个参数节点进行认证,第二个参数是用户UID
       if(!$auth->check( '/'.request()->module().'/'.request()->controller().'/'.request()->action(),session('user_auth.uid'))){
           $this->error('你没有权限');
       }*/
    }

    protected static  function  _check(){
        Loader::import('org\Auth', EXTEND_PATH);
       $auth = new Auth();
       //第一个参数节点进行认证,第二个参数是用户UID
       if(!$auth->check( '/'.request()->module().'/'.request()->controller().'/'.request()->action(),session('user_auth.uid'))){
           return false;
       }else{
           return true;
       }
    }
}
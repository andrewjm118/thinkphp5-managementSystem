<?php
namespace app\admin\controller;
use think\Request;
use think\Session;
use think\Db;
use org\MenuTool;
use think\Loader;
use think\Cache;

class Index
{
    use \traits\controller\Jump;
    public function __construct()
    {
        // session不存在时，不允许直接访问
        if(!Session::has('user_auth')){
            $this->error("还没有登陆",url('/login'));
        }
    }

    public function index()
    {
        $user_auth = Session::get('user_auth');
        return  view('',['nick'=>$user_auth['rule_name']]);
    }

    /**
     * @return \think\response\View
     */
    public function main(){
        //print_r(Session::get('user_auth'));
       // trace(\request()->session('user_auth'));
       return  view();
    }

    //获取菜单
    public function menuJson(){
        $rule_id = Session::get('user_auth.rule_id');

        $menu = Cache::get('menu_cache');
        if (!$menu) {
            $rule = Db::table('cuoti_auth_group')->where('id',$rule_id)->find();
            $result = Db::name('auth_rule')
                ->where('id', 'in', $rule['rules'])
                ->where('menu',1)
                ->select();
            //Cache::set('user_cache', $result);
            Loader::import('org\MenuTool', EXTEND_PATH);
            $menu = MenuTool::getMenu($result);
            Cache::set('menu_cache', $menu);
        }
        return $menu;

    }
}

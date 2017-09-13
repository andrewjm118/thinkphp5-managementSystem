<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/5/5
 * Time: 10:22
 */

namespace app\admin\controller;
use app\admin\model\AuthRule;
use org\MenuTool;
use think\Loader;
use think\Db;
use think\Session;

class Menu extends Common
{
    //菜单管理
     public function menuManage(){
            if(parent::_check()){
                $auth_rule = new AuthRule();
                $data = $auth_rule->order('index','asc')->select();
                Loader::import('org\MenuTool', EXTEND_PATH);
                $result = MenuTool::tree($data,"title");
               /* dump($result);
                exit();*/
                return view('menuManage',array('result'=>$result));
            }else{
                $this->error('你没有权限');
            }

     }


    //添加数据
    public function addMenu(){
        if(request()->isPost()){
            $params = input('post.');
            if(empty($params['status'])){
                $params['status'] = 0;
            }else{
                $params['status'] = 1;
            }
            if(empty($params['menu'])){
                $params['menu'] = 0;
            }else{
                $params['menu'] = 1;
            }
            $auth_rule = new AuthRule();
            $auth_rule->title = $params['title'];
            $auth_rule->name = $params['name'];
            $auth_rule->status = $params['status'];
            $auth_rule->menu = $params['menu'];
            $auth_rule->pid = $params['pid'];
            $is_name = $auth_rule->where("name",$params['name'])->find();
            if(empty($is_name)){
                if($auth_rule->save()){
                    return json(array('code'=>200,'msg'=>'添加成功'));
                }else{
                    return json(array('code'=>200,'msg'=>'添加失败'));
                }
            }else{
                return json(array('code'=>202,'msg'=>'权限规则已存在'));
            }

        }else{
            $params = input('get.pid');
            if(is_null($params)){
                return view('addMenu',array('pid'=>0));
            }else{
                return view('addMenu',array('pid'=>$params));
            }

        }

    }

    public function ceshi(){
        //request()->module())

    }

    //删除
    public function menuDel(){
        if(request()->isPost()) {
            $id = input('post.id');
            if(is_null($id)){
                return json(array('code'=>404,'msg'=>'删除失败','result'=>$id));
                //exit();
            }else{
                $auth_rule = new AuthRule();
                $count = $auth_rule->where("pid=".$id)->count();
                if($count>0){
                    return json(array('code'=>400,'msg'=>'有子权限不能删除','count'=>$count));
                }else{
                    $result = $auth_rule->where("id =".$id)->delete();
                    if($result){
                        return json(array('code'=>200,'msg'=>'删除成功','result'=>$result));
                    }else{
                        return json(array('code'=>400,'msg'=>'删除失败','result'=>$result));
                    }
                }
            }
        }else{
            //
        }
    }
    //编辑
    public function editMenu(){
        if(request()->isPost()){
            $params = input('post.');
            if(empty($params['status'])){
                $params['status'] = 0;
            }else{
                $params['status'] = 1;
            }
            if(empty($params['menu'])){
                $params['menu'] = 0;
            }else{
                $params['menu'] = 1;
            }

            $auth_rule = new AuthRule();
            $result = $auth_rule->save([
                'title'  => $params['title'],
                'name'   => $params['name'],
                'status' => $params['status'],
                'menu' => $params['menu'],
                'pid' => $params['pid']
            ],['id'=>$params['id']]);
            if($result !==false){
                return json(array('code'=>200,'msg'=>'保存成功','result'=>$result));
            }else{
                return json(array('code'=>202,'msg'=>'保存失败','result'=>$auth_rule->getLastSql()));
            }
        }else{
            $params = input('get.id');
            if(is_null($params)){
                exit();
            }else{
                $auth_rule = new AuthRule();
                $result = $auth_rule->where("id =".$params)->find();
                return view('editMenu',array('auth_rule'=>$result));
            }
        }

        // return view();
    }
}
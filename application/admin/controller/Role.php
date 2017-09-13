<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use app\admin\model\AuthGroup;
use app\admin\model\AuthRule;
use think\Cache;
use think\Loader;
use org\MenuTool;
use think\Request;

class Role
{
    //列表页
    public function roleManage(){
        $auth_group = new AuthGroup();
        $count = $auth_group->count();
        $result = $auth_group->limit(10)->order('sort','asc')->select();
        return view('roleManage',array('count'=>$count,'result'=>$result));
    }

    /**
     * 获取列表api
     * @return \think\response\Json
     */
    public function roleList($pageIndex = null,$pageSize = null,$keyword = null,$pageCount = null){
        $auth_group = new AuthGroup();
        if(is_null($pageIndex) || is_null($pageSize)){
               if(is_null($keyword)){
                   $data['count'] = $auth_group->count();
                   $data['list'] = $auth_group->limit($pageCount)->select();
                   return json($data);
               }else{
                   $data['count'] = $auth_group->where('title','like','%'.$keyword."%")->count();
                   $data['list'] = $auth_group->where('title','like','%'.$keyword."%")->limit($pageCount)->select();
                   return json($data);
               }
        }else{
            if(is_numeric($pageIndex) && is_numeric($pageSize)){

                    $data['rel'] = true;
                    $data['msg'] = "获取成功";
                    $firstRow =$pageSize * ($pageIndex - 1);
                if(is_null($keyword)) {
                    $data['list'] = $auth_group->limit($firstRow,$pageSize)->select();
                }else {
                    $data['list'] = $auth_group->where('title','like','%'.$keyword."%")->limit($firstRow,$pageSize)->select();
                }
                    return json($data);

                }

            }

        }


    //添加数据
    public function addRole(){
        if(request()->isPost()){
            $params = input('post.');
            if(empty($params['status'])){
                $params['status'] = 0;
            }else{
                $params['status'] = 1;
            }
            $auth_group = new AuthGroup();
            $auth_group->title = $params['title'];
            $auth_group->desc = $params['desc'];
            $auth_group->status = $params['status'];
            if($auth_group->save()){
                return json(array('code'=>200,'msg'=>'添加成功'));
            }
        }else{
            return view();
        }

    }

    //编辑
    public function editRole(){
        if(request()->isPost()){
            $params = input('post.');
            if(empty($params['status'])){
                $params['status'] = 0;
            }else{
                $params['status'] = 1;
            }
            $auth_group = new AuthGroup();
            $result = $auth_group->save([
                'title'  => $params['title'],
                'desc'   => $params['desc'],
                'status' => $params['status']
            ],['id'=>$params['id']]);
            if($result){
                return json(array('code'=>200,'msg'=>'添加成功','result'=>$result));
            }
        }else{
            $params = input('get.id');
            if(is_null($params)){
                exit();
            }else{
                $auth_group = new AuthGroup();
                $auth_result = $auth_group->where("id =".$params)->find();
                return view('editRole',array('auth_result'=>$auth_result));
            }
        }

       // return view();
    }

    //删除
    public function roleDel(){
        if(request()->isPost()) {
            $id = input('post.id');
            if(is_null($id)){
                return json(array('code'=>404,'msg'=>'添加失败','result'=>$id));
                //exit();
            }else{
                $auth_group = new AuthGroup();
                $auth_result = $auth_group->where("id =".$id)->delete();
                if($auth_result){
                    return json(array('code'=>200,'msg'=>'添加成功','result'=>$auth_result));
                }else{
                    return json(array('code'=>400,'msg'=>'添加失败','result'=>$auth_result));
                }
            }
        }else{
            //
        }
    }


    //设置权限
    public function setRole(){
        if(request()->isPost()) {
            $params = input('post.');
            $auth_group = new AuthGroup();
            $result = $auth_group->save([
                'rules' => $params['rules']
            ],['id'=>$params['id']]);
            if($result !==false){
                //Cache::clear();
                cache('menu_cache',null);
                return json(array('code'=>200,'msg'=>'权限设置成功','result'=>$result));
            }

        }else{
            $request = Request::instance();
            $params = $request->param('id');
            if(is_null($params)){
                exit();
            }else{
                $auth_rule = new AuthRule();
                $ids = AuthGroup::get($params);
                $rules = explode(',', $ids['rules']);
                $data = $auth_rule->select();
                Loader::import('org\MenuTool', EXTEND_PATH);
                $result = MenuTool::tree($data,"title",$rules);
                return view('setRole',array('auth_result'=>$result,'group_id'=>$params));
            }
        }

    }





}
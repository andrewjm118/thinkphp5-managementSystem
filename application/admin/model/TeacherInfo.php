<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class TeacherInfo extends Model
{
	//添加教师
 	function add($params){
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->tid;
		}else{
			return false;
		}
	}
	//编辑教师
	function edit($params){
		$result = $this->isUpdate(true)->allowField(true)->save($params);
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	//批量操作
	/**
	* 批量操作
	* $act  操作类型 delete
	* $params 参数
	*/
	function batches($act,$params){
		if($act == 'delete'){
			$result = $this->destroy($params);
		}
		if($result){
			return true;
		}else{
			return false;
		}
	}
	/**
	* 获取教师列表
	* $search 搜索条件
	* $order  排序
	* $page_size 每页显示数量
	*/
	function get_list($search='',$order='sort desc',$page_size=8){
		$tchlist = $this->where($search)->order($order)->paginate($page_size);
		if ($tchlist) {
			$tchlist = $tchlist->toArray();//对象转成数组
			return $tchlist;
		} else {
			return false;
		}
	}
	//获取未分配角色的老师
	function get_u_tea($tid){
		$tchlists=$this->where('tid','not in',$tid)->select();
		if ($tchlists) {
			$tchlists = collection($tchlists)->toArray();//对象转成数组
			return $tchlists;	
		} else {
			return;
		}
        
	}
	//获取当前登录老师信息
	function get_teadt($tid){
		$tea_detail = $this->where('tid',$tid)->find();
		if ($tea_detail) {
			return $tea_detail->toArray();
		} else {
			return;
		}
	}

	//排序
	function sort($params){
        $result = $this->allowField(true)->save($params, ['tid' => $params['tid']]);
        if($result!== false){
            return true;
        }else{
            return false;
        }

    }
}
<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class CourseInfo extends Model
{
	//添加课程
 	function add($params){
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->cid;
		}else{
			return false;
		}
	}
	//编辑课程
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
	function get_list($search='',$order='cid desc',$page_size=8){
		$tchlist = $this->where($search)->order($order)->paginate($page_size);
		if ($tchlist) {
			$tchlist = $tchlist->toArray();//对象转成数组
			return $tchlist;
		} else {
			return false;
		}
	}
}
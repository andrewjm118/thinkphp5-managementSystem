<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class StuInfo extends Model
{
    //编辑课程
	function edit($params){
		$result = $this->isUpdate(true)->allowField(true)->save($params);
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
	/**
	* 获取学生列表
	* $search 搜索条件
	* $order  排序
	* $page_size 每页显示数量
	*/
	function get_list($search='',$order='stuid desc',$page_size=8){
		$stulist = $this->where($search)->order($order)->paginate($page_size);
		if ($stulist) {
			$stulist = $stulist->toArray();//对象转成数组
			return $stulist;
		} else {
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
	//获取当前登录老师的学生
	function get_stus($stuid){
		$stus = $this->where('stuid','in',$stuid)->select();
		if ($stus) {
			return $stus;
		} else {
			return false;
		}
	}
}
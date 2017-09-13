<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class PayInfo extends Model
{
	//添加交费信息
 	function add($params){
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->payid;
		}else{
			return false;
		}
	}
	//编辑交费信息
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
	function get_list($search='',$order='payid desc',$page_size=8){
		$paylist = $this->where($search)->order($order)->paginate($page_size);
		if ($paylist) {
			$paylist = $paylist->toArray();//对象转成数组
			return $paylist;
		} else {
			return false;
		}
	}
	//查看该学生是否有余额交费
	function get_is_yu($paystu){
		$payyu = $this->where('paystu',$paystu)->find();
		if ($payyu) {
			return $payyu['payyu'];
		} else {
			return false;
		}
	}
	//添加上课纪录相应减少余额
	function get_jian_yu($paystu,$yjian){
		$payyu = $this->where('paystu',$paystu)->value('payyu');
		$params['payyu'] = $payyu-$yjian;
		$result = $this->isUpdate(true)->allowField(true)->save($params, ['paystu' => $paystu]);
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
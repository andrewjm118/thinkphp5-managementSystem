<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class ErrortestInfo extends Model
{
	//添加错题信息
 	function add($params){
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->etid;
		}else{
			return false;
		}
	}
	//编辑错题信息
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
	function get_list($search='',$order='etid desc',$page_size=8){
		$tchlist = $this->where($search)->order($order)->paginate($page_size);
		$sql = $this->getLastSql();
		if ($tchlist) {
			$tchlist = $tchlist->toArray();//对象转成数组
			return $tchlist;
		} else {
			return false;
		}
	}

	function details($etid = ''){
        //$tchlist = $tchlist->toArray();//对象转成数组
        return $this->where('etid',$etid)->field('tu_ids')->find();
    }
}
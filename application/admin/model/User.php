<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class User extends Model
{
	//添加错题信息
 	function add($params){
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->uid;
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
	function get_list($search='',$order='uid desc',$page_size=8){
		$tchlist = $this
		->alias('u')
		->join('__AUTH_GROUP__ a','a.id=u.rule_id')
		->where($search)->order($order)->paginate($page_size);
		if ($tchlist) {
			$tchlist = $tchlist->toArray();//对象转成数组
			return $tchlist;
		} else {
			return false;
		}
	}
	//获取当前登录老师学生的stuid
	function get_userdt($uid){
		$stuids = $this->where('uid',$uid)->find();
		if ($stuids) {
			return $stuids;
		} else {
			return false;
		}
	}

	//获取教师id信息
    function get_tchid($uid){
        $tchid = $this->where('uid',$uid)->field('teacher_id')->find();

        if ($tchid) {
            return $tchid;
        } else {
            return false;
        }
    }


}
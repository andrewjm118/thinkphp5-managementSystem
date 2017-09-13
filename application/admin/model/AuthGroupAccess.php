<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\admin\model;
use think\Model;
class AuthGroupAccess extends Model
{
    //添加
 	function add($params){
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	//修改
	function upd($uid,$group_id){
		$result = $this->where('uid', $uid)->update(['group_id' => $group_id]);
		if($result !== false){
			return true;
		}else{
			return false;
		}
	}
}
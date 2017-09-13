<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/5/22
 * Time: 16:47
 */
namespace app\api\controller\v2;
use app\api\model\User as UserModel;

class User
{
    public function read($id = 0){
         $user = UserModel::get($id,'profile');
            if ($user) {
                return json($user);
            } else {
                return json(['error' => '用户不存在'], 404);
            }
    }

}
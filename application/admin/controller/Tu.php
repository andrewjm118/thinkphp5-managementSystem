<?php
/*///**
// * Created by PhpStorm.
// * User: andrewjm
// * Date: 2017/5/11
// * Time: 16:07
// */
//
namespace app\admin\controller;
use think\Db;
use think\Session;
use think\Cache;
use app\admin\model\Logs;

class Tu extends Common
{

    use\traits\controller\Jump;
    //添加图片
    public function add(){
        if(request()->isPost()){
            $params = input('param.');
            Db::name('tu')
                ->insert(['tu_name' => $params['name'], 'tu_type' => $params['type'],'tu_size'=>$params['size'],'tu_user'=>session('user_auth.uid'),'tu_url'=>$params['url']]);
            $userId = Db::name('tu')->getLastInsID();
            return json(['code'=>200,'msg'=>'上传成功','tu_id'=>$userId]);
        }else{
            return 1;
        }
    }


}
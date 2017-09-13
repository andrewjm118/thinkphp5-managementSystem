<?php

/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/21
 * Time: 13:21
 */
namespace app\api\model;
use think\Model;
class Profile extends Model
{
    protected $type = [
        'birthday' => 'timestamp:Y-m-d',
    ];

    
}
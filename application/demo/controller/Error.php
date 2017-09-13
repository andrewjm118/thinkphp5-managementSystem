<?php
namespace app\demo\controller;

class Error{
    //空方法
    public function _empty($method)
    {
        return '当前操作名：' . $method;
    }
}
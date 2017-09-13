<?php
namespace app\demo\controller;
use think\Controller;
class Index extends Controller
{

    protected $beforeActionList = [
        'first',
        'second' => ['except'=>'hello'],
        'three'  =>  ['only'=>'hello,data'],
    ];

    protected function first()
    {
        echo 'first<br/>';
    }

    protected function second()
    {
        echo 'second<br/>';
    }

    protected function three()
    {
        echo 'three<br/>';
    }

    public function hello()
    {
        return 'hello';
    }

    public function data()
    {
        return 'data';
    }

    public function hello1()
    {
        return 'data';
    }
}
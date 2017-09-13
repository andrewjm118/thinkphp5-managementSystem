<?php
/**
 * Created by PhpStorm.
 * User: andrewjm
 * Date: 2017/4/18
 * Time: 12:57
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\StuInfo;
use app\admin\model\TypeVal;
class Stu  extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $this->typeval = new TypeVal();

    }
    //学生列表
    public function stulist()
    {
        $params = input('param.');
        $order = 'stuid desc';
        $search ='';
        if(!empty($params['search']) && is_array($params['search'])){
            foreach ($params['search'] as $k => $v) {
                if($v){
                    $search[$k] = array('like','%'.$v.'%'); 
                }
            }
        }
        $page_size =!empty($params['page_size'])?$params['page_size']:'';
        $stuinfo = new StuInfo();
        $url_params =!empty(parse_url(request()->url(true))['query'])?parse_url(request()->url(true))['query']:'';
        $stulist = $stuinfo->get_list($search,$order,$page_size);
        return view('stulist',['result'=>$stulist['data'],'total'=>$stulist['total'],'per_page'=>$stulist['per_page'],'current_page'=>$stulist['current_page'],'search'=>!empty($params['search'])?$v:'','url_params'=>$url_params]);
    }
    //添加学生信息
    public function stuadd(){
        if(request()->isPost()){
            $params = input('post.');
            $StuInfo = new StuInfo();
            $result = $StuInfo->isUpdate(false)->allowField(true)->save($params);
            if($result){
                return json(array('code'=>200,'msg'=>'添加成功'));
            }else{
                return json(array('code'=>0,'msg'=>'添加失败'));
            }
        }else{
            $kemu = $this->typeval->where('ti_id',5)->select();
            $stufrom = $this->typeval->where('ti_id',6)->select();
            $grade = $this->typeval->where('ti_id',10)->select();
            return view('',['kemu'=>$kemu,'stufrom'=>$stufrom,'grade'=>$grade]);
        }
    }
	//编辑学生信息
    public function stuedit(){
        if (request()->isPost()) {
            $params = input('post.');
            $stuinfo = new StuInfo();
            $result = $stuinfo -> edit($params);
            if ($result) {
                return json(['code'=>200,'msg'=>'编辑成功']);
            } else {
                return json(['code'=>0,'msg'=>'编辑失败']);
            }
        } else {
            $stuinfo = new StuInfo();
            $studetail = $stuinfo->where('stuid',input('stuid'))->find();
            return view('stuedit',['studetail'=>$studetail]);
        }
    }
    //删除学生信息
    public function studel(){
        $stuinfo = new StuInfo();
        $result = $stuinfo->destroy(input('post.stuid'));
        if($result){
            return json(array('code'=>200,'msg'=>'删除成功'));
        }else{
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
    }
    //批量删除
    public function batches_delete(){
        $params = input('post.');
        $ids = implode(',', $params['stuid']);
        $stuinfo = new StuInfo();
        $result = $stuinfo->batches('delete',$ids);
        if($result){
            return json(['code'=>200,'msg'=>'批量删除成功']);
        }else{
            return json(['code'=>0,'msg'=>'批量删除失败']);
        }
    }

	//上传图片
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $path = '/uploads/'.$info->getSaveName();
            return json(['code'=>0,'msg'=>'上传成功','data'=>['src'=>$path]]);
        }else{
            return json(['code'=>200,'msg'=>'上传失败']);
        }
    }

}
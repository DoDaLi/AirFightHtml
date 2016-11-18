<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show();
    }

    public function addPlane()
    {
    	$mapLen = I('post.mapLen');
    	$mapWid = I('post.mapWid');
    	$planeMap = I('post.planeMap');
    	$model = D("Index");
        $res = $model->addPlane($planeMap);
    }
}
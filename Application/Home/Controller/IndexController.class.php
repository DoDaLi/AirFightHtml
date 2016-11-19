<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show();
    }

    public function addHost()
    {
        $mapLen = I('post.mapLen');
        $mapWid = I('post.mapWid');
        $planeMap = I('post.planeMap');
        $model = D("Index");
        $roomId = $model->joinAsHost();
        if ($roomId > 0) {
            $res = $model->addPlane($roomId,0,$planeMap);
        }
        else{
            return -1;
        }

        
    }
}
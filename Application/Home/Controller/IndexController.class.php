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
            $res = $model->addPlane($roomId, 1, $planeMap, $mapLen, $mapWid);
            if ($res) {
                echo $roomId;
                return;
            }
        }
        echo -1;
        return;
        
    }

    public function addChallenger()
    {
        $mapLen = I('post.mapLen');
        $mapWid = I('post.mapWid');
        $planeMap = I('post.planeMap');
        $roomId = I('post.roomId');
        $model = D("Index");
        $joinRes = $model->joinAsChallenger($roomId);
        if ($joinRes > 0) {
            $res = $model->addPlane($roomId, 2, $planeMap, $mapLen, $mapWid);
            if ($res) {
                echo $roomId;
                return;
            }
        }
        echo -1;
        return;
        
    }
}
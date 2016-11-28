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
                $result["status"] = "success";
                $result["roomId"] = $roomId;
                echo json_encode($result);
                return;
            }
        }
        $result["status"] = "fail";
        $result["info"] = "error";
        echo json_encode($result);
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
                $result["status"] = "success";
                $result["roomId"] = $roomId;
                echo json_encode($result);
                return;
            }
        }
        $result["status"] = "fail";
        $result["info"] = "error";
        echo json_encode($result);
        return;
    }

    public function gameRound()
    {
        $roomId = I('post.roomId');
        $round = I('post.round');
        $player = I('post.player');
        $model = D("Index");
        if ($round == 1 && $player == 1) {
            $cnt = 10;
            while ($cnt--) {
                $chaStatus = $model->checkChallengerStatus($roomId);
                if ($chaStatus) {
                    $result["status"] = "shoot";
                    $result["info"] = "挑战者来临！开始对局！房主先手射击。";
                    echo json_encode($result);
                    return;
                }
                sleep(3);
            }
            $result["status"] = "wait";
            echo json_encode($result);
            return;
        }
        // -1: wait  1:shoot  10:host win 11:challenger win
        $roomStatus = $model->checkRoomStatus($roomId, $round, $player);
    }
}
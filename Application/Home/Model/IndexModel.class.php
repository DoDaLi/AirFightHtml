<?php
namespace Home\Model;
use Think\Model;
class IndexModel extends Model {
    public function __construct(){
    }

    public function addPlane($roomId, $playerType, $planeMap, $mapLen, $mapWid)
    {
        $model = M("");
        $sql = "INSERT INTO plane_location(room_id,player,cor_x,cor_y,loc_type) VALUES";
        for ($i=0; $i < $mapLen; $i++) { 
            for ($j=0; $j < $mapWid; $j++) {
                $dot = $planeMap[$i][$j];
                if ($dot) {
                    $sql = $sql."(".$roomId.",".$playerType.",".$i.",".$j.",".$dot."),";
                }
            }
        }
        $sql = substr($sql, 0, strlen($sql) - 1).";";
        $res = $model->execute($sql);
        if ($res) {
            return 1;
        }
        return false;
    }

    public function joinAsHost($hostId = NULL, $planeNum = 3)
    {
        $model = M("");
        $res0 = $model->query("SELECT MAX(room_id) FROM battle_room");
        $sql = "INSERT INTO battle_room(room_id) VALUE(".$res0[0]["max(room_id)"]."+1)";
        $res1 = $model->execute($sql);
        if ($res1 == 1) {
            return (int)$res0[0]["max(room_id)"] + 1;
        }
        else return false;
    }

    public function joinAsChallenger($roomId, $ChallengerId = 1)
    {
        $model = M("");
        $sql = "UPDATE battle_room SET challenger_id = ".$ChallengerId." WHERE room_id = ".$roomId.";";
        $res1 = $model->execute($sql);
        if ($res1 == 1) {
            return 1;
        }
        else return false;
    }

    public function checkChallengerStatus($roomId)
    {
        $model = M("");
        $sql = "SELECT challenger_id FROM battle_room WHERE room_id = ".$roomId.";";
        $res = $model->query($sql);
        if ($res[0]["challenger_id"]) {
            return 1;
        }
        return false;
    }

    public function checkRoomStatus($roomId, $round, $player, $planeNum = 3)
    {
        
        $model = M("");
        $sql0 = "SELECT * FROM battle_room WHERE room_id = ".$roomId.";";
        $battlerRes = $model->query($sql0);
        if ($battlerRes[0]["kill_host"] == $battlerRes[0]["plane_num"]) {
            return 10;
        }
        if ($battlerRes[0]["kill_challenger"] == $battlerRes[0]["plane_num"]) {
            return 11;
        }
        $sql = "SELECT * FROM battle_log WHERE room_id = ".$roomId." AND `round` = ".$round.";";
        $res = $model->query($sql);
        if (!$res && $player == 1) {
            return 1;
        }
        var_dump($res);die;
    }
}
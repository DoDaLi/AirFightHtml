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
        $battleRes = $model->query($sql0);
        if ($battleRes[0]["kill_host"] == $battleRes[0]["plane_num"]) {
            $result["status"] = "end";
            $result["info"] = "Host win!";
            return $result;
        }
        if ($battleRes[0]["kill_challenger"] == $battleRes[0]["plane_num"]) {
            $result["status"] = "end";
            $result["info"] = "Challenger win!";
            return $result;
        }
        if ($player == 1) {
            $sql = "SELECT * FROM battle_log WHERE room_id = ".$roomId." AND `round` = ".($round - 1).";";
            $res = $model->query($sql);
            if ($res[0]["challenger_done"] == 0) {
                $result["status"] = "wait";
                return $result;
            }
            $result["status"] = "shoot";
            $result["round"] = $round - 1;
            $result["x"] = $res[0]["challenger_x"];
            $result["y"] = $res[0]["challenger_y"];
            $result["result"] = $res[0]["challenger_result"] - 0;
            return $result;
        }
        if ($player == 2) {
            $sql = "SELECT * FROM battle_log WHERE room_id = ".$roomId." AND `round` = ".$round.";";
            $res = $model->query($sql);
            if ($res[0]["host_done"] == 0) {
                $result["status"] = "wait";
                return $result;
            }
            $result["status"] = "shoot";
            $result["round"] = $round;
            $result["x"] = $res[0]["host_x"];
            $result["y"] = $res[0]["host_y"];
            $result["result"] = $res[0]["host_result"] - 0;
            return $result;
        } else {
            $result["status"] = "error";
            $result["info"] = "player type error";
            return $result;
        }
    }

    public function shoot($roomId, $round, $player, $locX, $locY)
    {
        $model = M("");
        $sql = "SELECT loc_type FROM plane_location 
                WHERE room_id = ".$roomId."
                AND player = ".(($player == 1)?2:1)."
                AND cor_x = ".$locX."
                AND cor_y = ".$locY.";";
        $res = $model->query($sql);
        if (!$res) {
            $result = 0;
        } else {
            $result = $res[0]["loc_type"];
        }
        $sqlRoom = "";
        if ($result == 5) {
            $character = ($player == 1)?"kill_host":"kill_challenger";
            $sqlRoom = "UPDATE battle_room 
                        SET ".$character." = ".$character." + 1
                        WHERE room_id = ".$roomId.";";
        }
        if ($player == 1) {
            $sql = "INSERT INTO battle_log(room_id, `round`, host_done,host_x,host_y,host_result)
                VALUE(".$roomId.",".$round.",1,".$locX.",".$locY.",".$result.");".$sqlRoom;
        } else {
            $sql = "UPDATE battle_log 
                    SET challenger_done = 1,
                    challenger_x = ".$locX.",
                    challenger_y = ".$locY.",
                    challenger_result = ".$result."
                    WHERE room_id = ".$roomId."
                    AND `round` = ".$round.";".$sqlRoom;
        }
        $res = $model->execute($sql);
        if ($res) {
            return $result;
        }
        return -1;
    }


    public function tellResult($value)
    {
        switch ($value) {
            case 0:
                return "未击中";
            case 1:
                return "击中机身";
            case 5:
                return "击中机头";
            default:
                return "系统错误";
        }
    }
}
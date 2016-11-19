<?php
namespace Home\Model;
use Think\Model;
class IndexModel extends Model {
    public function __construct(){
    }

    public function addPlane($roomId, $playerType, $planeMap)
    {
        
        
    }

    public function joinAsHost($hostId = NULL,$planeNum = 3)
    {
        $model = M("");
        $res0 = $model->query("SELECT MAX(room_id) FROM battle_room");
        $sql = "INSERT INTO battle_room(room_id) VALUE(".$res0[0]["max(room_id)"]."+1)";
        $res1 = $model->execute($sql);
        if ($res1 == 1) {
            return (int)$res0[0]["max(room_id)"] + 1;
        }
        else return -1;
    }

    public function joinAsChallenger()
    {
        # code...
    }
}
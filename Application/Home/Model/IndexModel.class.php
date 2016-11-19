<?php
namespace Home\Model;
use Think\Model;
class IndexModel extends Model {
    public function __construct(){
    }

    public function addPlane($planeMap)
    {
        echo "11111111111111111";
        $model = M("");
        $result = $model->query("select * from plane_location;");
    	var_dump($result);die;
    }
}
<?php
namespace Home\Model;
use Think\Model;
class AuthModel extends Model {
    public function __construct(){
    }


    public function checkSameName($name)
    {
        $model = M("");
        $res = $model->query("SELECT * FROM user_info WHERE user_name = '%s'",$name);
        if ($res) {
            return true;
        }
        return false;
    }
}
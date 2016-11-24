<?php
namespace Home\Controller;
use Think\Controller;
class AuthController extends Controller {
    public function index(){
        $this->show("login");
    }

    public function signUp()
    {
        $this->display();
    }

    public function checkSameName()
    {
        $name = I('post.username');
        $model = D("Auth");
        $res = $model->checkSameName($name);
        if ($res) {
            echo '<text class="btn-danger">用户名重复，请重新输入</text>';
            return;
        }
        echo '<text class="btn-success">用户名可用</text>';
        return;
    }
}
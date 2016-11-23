<?php
namespace Home\Controller;
use Think\Controller;
class AuthController extends Controller {
    public function index(){
        $this->show("login");
    }

}
<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{

     public function _initialize(){
     	if(($_SESSION['username'] == null || $_SESSION['password']==null)){
             if($_COOKIE['remember'] != null){
                 $name = explode(':', $_COOKIE['remember']);
                 $password = explode(':', $_COOKIE['remember']);
             	$_SESSION['username'] = $name[0];
             	$_SESSION['password'] = $password[1];
             	$this->redirect("index/index");
             }
              $this->redirect("Login/index");
     	}
     }

}

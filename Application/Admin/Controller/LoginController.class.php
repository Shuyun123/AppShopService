<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
    
    public function index(){
    	$this->display("index");
    }
    public function dealData(){

       $username = I('username',null,'htmlspecialchars'); 
       $password = I('password',null,'htmlspecialchars'); 
       $remember = I('checkbox',0,'htmlspecialchars');

       if($username != null && $password != null ){  
 
            $data = M()->table('admin')->where(array('username'=>$username))->find();
            if($data['username'] == $username && $data['password']== md5($password)){
            	$_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['remember'] = $remember;                
                M()->table('admin')->where('id=1')->setField('logintime',time());
                if($remember == 1){
                	cookie('remember',$username.":".$password,time()+3600*24);
                }
                $this->redirect("Index/index");                 
            }else{
            	echo "<script> alert('用户名或密码错误!');parent.location.href='index.html'; </script>";
   	    	    exit();
            }
   
       }else if($username == null){
            echo "<script> alert('用户名不能为空!');parent.location.href='index.html'; </script>";
   	    	exit();
       }else if($password == null){
            echo "<script> alert('密码不能为空!');parent.location.href='index.html'; </script>";
   	    	exit();
       }
    }

}

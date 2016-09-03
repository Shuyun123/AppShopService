<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    /**
     * 注册接口:
     *
     * result:0101  //注册手机号类型不对
     * result:0102  //注册手机号已经存在
     * result:0103  //注册用户名已经存在
     * result:0104  //两次密码不一致
     * result:0200  //注册成功
     * result:0404  //注册失败
     * result:0100  //没有数据
     */

    private  $PHONE_TYPE_FALSE= "0101";

    private  $PHONE_EXIST = "0102";

    private  $USER_EXIST = "0103";

    private  $PASSWORD_ERROR = "0104";

    private  $RESGISTER_SUCCESS = "0200";

    private  $RESGISTER_FAILD = "0404";

    private  $NO_DATA = "0100";


    /**
     * 用户登录接口
     *
     * result:0102   //手机号不存在
     * result:0100   //密码不正确
     * result:用户注册id   //登录成功
     */
     private $PHONE_NO_EXIST = "0102";

     private $LOGIN_PASSWORD_ERROR = "0100";





    /**
     * 用户订单上传接口
     *
     * result:0200   //上传成功
     * result:0404   //上传失败
     */
     private $UPLOAD_ORDER_SUCCESS = "0200";

     private $UPLOAD_ORDER_FAILD = "0404";


    /**
     * 用户订单删除接口
     *
     * result:0200   //删除成功
     * result:0404   //删除失败
     */
    private $DELETE_ORDER_SUCCESS = "0200";

    private $DELETE_ORDER_FAILD = "0404";


    /**
     * 用户发布评价接口
     *
     * result:0200   //发布成功
     * result:0404   //发布失败
     */
    private $PUBLISH_COMMENT_SUCCESS = "0200";

    private $PUBLISH_COMMENT_FAILD = "0404";


    /**
     * 用户发布评论接口
     *
     * result:0200   //发布成功
     * result:0404   //发布失败
     */
    private $PUBLISH_SUB_COMMENT_SUCCESS = "0200";

    private $PUBLISH_SUB_COMMENT_FAILD = "0404";


    public function index(){
        //echo "App";
        $this->display("index");
    }


    public function register(){
        $HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];
        $encodeData = json_decode($HTTP_RAW_POST_DATA);
        $phoneNumber =  $encodeData->phoneNumber;
        $userName = $encodeData->userName;
        $password = $encodeData->password;
        $password_again = $encodeData->password_again;
        if($phoneNumber != null && $userName != null && $password != null){
            if(!$this->checkPhoneNumber($phoneNumber)){
                echo $this->PHONE_TYPE_FALSE;
                die;
            }

            if($this->checkUserExist($userName)){
                echo $this->USER_EXIST;
                die;

            }

            if($this->checkPhoneExist($phoneNumber)){
                echo $this->PHONE_EXIST;
                die;

            }

            if($password != $password_again){
                echo $this->PASSWORD_ERROR;
                die;

            }

            $data["phone"] =  $phoneNumber;
            $data["userName"] = $userName;
            $data["passWord"] = md5($password);
            $data["loginTime"] = time();
            $result = M()->table('user')->data($data)->add();
            if($result != null){
                echo $this->RESGISTER_SUCCESS;
                die;
            }else{
                echo $this->RESGISTER_FAILD;
                die;
            }
        }else{
            echo $this->NO_DATA;
            die;
        }

    }


    /**
     *删除用户的订单
     */
    public function deleteOrderData(){
        $uid =  I("uid",null);
        $pid = I("pid",null);
        $oid = I("oid",null);

       if($uid != null && $pid != null && $oid != null){
          if(is_numeric($uid) && is_numeric($pid) && is_numeric($oid)){
              $row_uid =  bindec($uid/2);
              $row_pid =  bindec($pid/2);
              $row_oid = bindec($oid/2);
              $Rusult = M()->table('buy')->where("id = $row_oid and ( pid = $row_pid and uid = $row_uid )" )->delete();
              if($Rusult != null){
                  echo $this->DELETE_ORDER_SUCCESS;
              }else{
                  echo $this->DELETE_ORDER_FAILD;
              }
          }else{
              echo $this->DELETE_ORDER_FAILD;
          }
       }else{
           echo $this->DELETE_ORDER_FAILD;
       }

    }



    public function uploadPicture(){
        $uid = I('uid',-1,'htmlspecialchars');
        $sub_path = "./Uploads/icon/". basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $sub_path)) {
            if($uid > 0){
                $data["iconimg"] = "/Uploads/icon/". basename($_FILES['image']['name']);
                $result = M()->table('user')->where("id=$uid")->save($data);
                if($result != null){
                    $realResult["iconImg"] = C("APP_WEB").$data["iconimg"];
                    $realResult["result"] = "0200";
                    echo json_encode($realResult);
                }else{
                    echo "0404";
                }
            }
        } else {
            echo "0404";
        }
    }


    public function getAllOrderData(){
        $uid = I('uid',-1,'htmlspecialchars');
        if(is_numeric($uid) && $uid > 0){
            $result = M()->table('user')->join('RIGHT JOIN buy ON buy.uid = user.id')->where("user.id = $uid")->select();
            if($result != null) {
                for($i = 0;$i<count($result);$i++){
                    $productResult = M()->table('product')->where("id = ".$result[$i]["pid"])->find();
                    $data[$i]["bid"] = $result[$i]["id"];
                    $data[$i]["price"] = $productResult["price"];
                    $data[$i]["sum"] = $result[$i]["sum"];
                    $data[$i]["total"] = $result[$i]["total"];
                    $data[$i]["isPay"] = $result[$i]["ispay"];
                    $data[$i]["isDeliver"] = $result[$i]["isdeliver"];
                    $data[$i]["isComment"] = $result[$i]["iscomment"];
                    $data[$i]["type"] = $productResult["type"];
                    $data[$i]["carrieroperator"] = $productResult["carrieroperator"];
                    $data[$i]["color"] = $productResult["color"];
                    $data[$i]["storage"] = $productResult["storage"];
                    $data[$i]["productName"] = $productResult["name"];
                    $data[$i]["uid"] = $result[$i]["uid"];
                    $data[$i]["pid"] = $result[$i]["pid"];
                    $data[$i]["img"] = C("APP_WEB").$productResult["img"];
                }

            }else{
                $data[0]["bid"] = "404";
                $data[0]["price"] = "404";
                $data[0]["sum"] = "404";
                $data[0]["total"] = "404";
                $data[0]["isPay"] = "404";
                $data[0]["isDeliver"] = "404";
                $data[0]["isComment"] = "404";
                $data[0]["type"] = "404";
                $data[0]["carrieroperator"] = "404";
                $data[0]["color"] = "404";
                $data[0]["storage"] = "404";
                $data[0]["productName"] = "404";
                $data[0]["uid"] = "404";
                $data[0]["pid"] = "404";
                $data[0]["img"] = "404";
            }

            echo json_encode($data);
        }
    }


    public function getUpdateAppInfo(){
        $resultInfo = M()->table('updateapp')->order('updatetime desc')->select();
        $data["appPath"] = $resultInfo[0]["apppath"];
        //$data["appName"] = $resultInfo[0]["appname"];
        $data["versionCode"] = $resultInfo[0]["versioncode"];
        $data["versionName"] = $resultInfo[0]["versionname"];
        $data["updateContent"] = $resultInfo[0]["updatecontent"];
        echo json_encode($data);
    }


 public function getUpdateInfo(){
        $data["appPath"] = "趣无穷.apk";
        //$data["appName"] = $resultInfo[0]["appname"];
        $data["versionCode"] = "1";
        $data["versionName"] = "1";
        $data["updateContent"] = "更改用户界面布局bug\r\n更改自动更新设置";
        echo json_encode($data);
    }


    public function updateUserSettingName(){
        $value = I('value',-1,'htmlspecialchars');
        $type = I('type',-1,'htmlspecialchars');
        $uid = I('uid',-1,'htmlspecialchars');
        if($value != null && is_numeric($type) && $type > 0 && is_numeric($uid) && $uid > 0){
            if($type == 1){
                $data['username'] = $value;
            }else if($type == 2){
                $data['signname'] = $value;
            }
            $result = M()->table('user')->where("id=$uid")->save($data);
            if($result != null){
                echo "0200";
            }else{
                echo "0400";
            }
        }else{
            echo "data error";
        }
    }




    public function uploadOrder(){
        $HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];
        $encodeData = json_decode($HTTP_RAW_POST_DATA);
        $pid =  $encodeData->pid;
        $uid = $encodeData->uid;
        $sum = $encodeData->sum;

        if($uid >0 && $pid >0 && $sum >0){

            if($this->checkUserExist(null,$uid) && $this->getProductPrice($pid)){
                $price = $this->getProductPrice($pid);
                $total = $price * $sum;
                $data["pid"] =  $pid;
                $data["uid"] = $uid;
                $data["sum"] = $sum;
                $data["total"] = $total;
                $result = M()->table('buy')->data($data)->add();
                if($result != null){
                    echo $this->UPLOAD_ORDER_SUCCESS;
                    die;
                }else{
                    echo $this->UPLOAD_ORDER_FAILD;
                    die;
                }
            }else{
                echo "data error!";
            }
        }else{
            echo "data error!";
        }
    }


    public function uploadSubComment(){
        $HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];
        $encodeData = json_decode($HTTP_RAW_POST_DATA);
        $uid = $encodeData->uid;
        $cid = $encodeData->cid;
        $subCommentContent = $encodeData->subCommentContent;
        if($uid > 0 && $cid > 0 && $subCommentContent != null){
            $data["uid"] = $uid;
            $data["cid"] = $cid;
            $data["commentcontent"] = $subCommentContent;
            $data["commenttime"] = time();
            $data["like"] = 0;
            $result = M()->table('subcomment')->data($data)->add();
            if($result != null){
                echo $this->PUBLISH_SUB_COMMENT_SUCCESS;
            }else{
                echo $this->PUBLISH_SUB_COMMENT_FAILD;
            }
        }else{
            echo "data error";
        }

    }

    public function getSubCommentData(){
        $id = I('cid',-1,'htmlspecialchars');
        if(is_numeric($id) && $id > 0){
            $result = M()->table('user')->join('RIGHT JOIN subcomment ON subcomment.uid = user.id')->where("cid = $id")->select();
            if($result != null){
                for($i=0;$i<count($result);$i++){
                    $data[$i]["sid"] = $result[$i]["id"];
                    $data[$i]["cid"] = $result[$i]["cid"];
                    $data[$i]["likeNumber"] = $result[$i]["like"];
                    $data[$i]["uid"] = $result[$i]["uid"];
                    $data[$i]["userImg"] = C("APP_WEB").$result[$i]["iconimg"];
                    $data[$i]["userName"] = $result[$i]["username"];
                    $data[$i]["subCommentContent"] = $result[$i]["commentcontent"];
                    $data[$i]["subTime"] = date('m月d日 h:i',$result[$i]["commenttime"]);
                }
            }else{
                $data[0]["cid"] = "404";
                $data[0]["sid"] = "404";
                $data[0]["likeNumber"] = "404";
                $data[0]["uid"] = "404";
                $data[0]["userImg"] = "404";
                $data[0]["userName"] = "404";
                $data[0]["subCommentContent"] = "404";
                $data[0]["subTime"] = "404";
            }

            echo json_encode($data);
        }

    }



    public function getProductPrice($pid){
        $productRusult = M()->table('product')->where("id =".$pid)->find();
        if($productRusult != null){
            return $productRusult["price"];
        }else{
            return -1;
        }
    }

     public  function getCommentData(){
         $comentResult = M()->table('comment')->join('LEFT JOIN product ON comment.pid = product.id')->join('LEFT JOIN user ON comment.uid = user.id')->select();
         $idResult = M()->table('comment')->field('id')->select();
         if($comentResult != null){
             for($i=0;$i<count($comentResult);$i++){
                 $data[$i]["uid"] = $comentResult[$i]["uid"];
                 $data[$i]["pid"] = $comentResult[$i]["pid"];
                 $data[$i]["cid"] = $idResult[$i]["id"];
                 $subCount = M()->table('subcomment')->where("cid = ".$data[$i]["cid"])->select();
                 $data[$i]["subCount"] = count($subCount);
                 $data[$i]["likeNumber"] = $comentResult[$i]["like"];
                 $data[$i]["commentTime"] = date('Y.m.d',$comentResult[$i]["commenttime"] );
                 $data[$i]["deliver"] = $comentResult[$i]["deliver"];
                 $data[$i]["service"] = $comentResult[$i]["service"];
                 $data[$i]["describe"] = $comentResult[$i]["describe"];
                 $data[$i]["commentContent"] = $comentResult[$i]["commentcontent"];
                 $data[$i]["userName"] = $comentResult[$i]["username"];
                 $data[$i]["img"] = C("APP_WEB").$comentResult[$i]["img"];
                 $data[$i]["type"] = $comentResult[$i]["type"];
                 $data[$i]["carrieroperator"] = $comentResult[$i]["carrieroperator"];
                 $data[$i]["color"] = $comentResult[$i]["color"];
                 $data[$i]["storage"] = $comentResult[$i]["storage"];
                 $data[$i]["productName"] = $comentResult[$i]["name"];
                 $data[$i]["userIcon"] = C("APP_WEB").$comentResult[$i]["iconimg"];

             }

         }else{
             $data[0]["uid"] = "404";
             $data[0]["pid"] = "404";
             $data[0]["cid"] = "404";
             $data[0]["likeNumber"] = "404";
             $data[0]["userIcon"] = "404";
             $data[0]["commentTime"] = "404";
             $data[0]["deliver"] = "404";
             $data[0]["service"] = "404";
             $data[0]["describe"] = "404";
             $data[0]["commentContent"] = "404";
             $data[0]["userName"] = "404";
             $data[0]["img"] = "404";
             $data[0]["type"] = "404";
             $data[0]["carrieroperator"] = "404";
             $data[0]["color"] = "404";
             $data[0]["storage"] = "404";
             $data[0]["productName"] = "404";
         }

         echo json_encode($data);
     }



    public  function publishCommentData(){
        $HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];
        $encodeData = json_decode($HTTP_RAW_POST_DATA);
        $pid =  $encodeData->pid;
        $uid = $encodeData->uid;
        $bid = $encodeData->bid;
        $commentContent = $encodeData->commentContent;
        $describe = $encodeData->describe;
        $deliver = $encodeData->deliver;
        $service = $encodeData->service;

        if($pid>0 && $uid >0 && $bid >0 && $commentContent != null && is_numeric($describe) && is_numeric($deliver) && is_numeric($service)){
            $data["pid"] =  $pid;
            $data["uid"] = $uid;
            $data["bid"] = $bid;
            $data["commentcontent"] = $commentContent;
            $data["describe"] = $describe;
            $data["deliver"] = $deliver;
            $data["service"] = $service;
            $data["commenttime"] = time();
            $data["subcount"] = 0;
            $result = M()->table('comment')->data($data)->add();
            if($result != null){
                if($this->upadateBuyCommentState($bid,$uid,$pid)){
                        echo $this->PUBLISH_COMMENT_SUCCESS;
                }
            }else{
                echo $this->PUBLISH_COMMENT_FAILD;
            }
        }else{
            echo $this->PUBLISH_COMMENT_FAILD;
        }

    }

    public function updateLikes(){
        $id = I('cid',-1,'htmlspecialchars');
        $value= I('likeNumber',-1,'htmlspecialchars');

        if(is_numeric($id) && is_numeric($value)  &&  $value >= 0){
            $data['like'] = $value;
            $result = M()->table('comment')->where("id=$id")->save($data);
            if($result != null){
                echo "0200";
            }else{
                echo "0404";
            }
        }
    }


    public function updateSubLikes(){
        $id = I('sid',-1,'htmlspecialchars');
        $value= I('likeNumber',-1,'htmlspecialchars');

        if(is_numeric($id) && is_numeric($value)  &&  $value >= 0){
            $data['like'] = $value;
            $result = M()->table('subcomment')->where("id = $id")->save($data);
            if($result != null){
                echo "0200";
            }else{
                echo "0404";
            }
        }
    }


    public  function upadateBuyCommentState($bid,$uid,$pid){
        $data['isComment'] = 1;
        $Rusult = M()->table('buy')->where("id = $bid and ( pid = $pid and uid = $uid )" )->save($data);
        if($Rusult != null){
            return true;
        }
       return false;
    }



    public function getBanners(){
        $result = M()->table('banner')->select();
        $i = 0;
        foreach($result as $value){
            $data[$i]["name"] = $value["name"];
            $data[$i]["introduce"] = $value["introduce"];
            $data[$i]["imageUrl"]  = C("APP_WEB").$value["img"];
            $i++;
        }
        echo json_encode($data);
    }

    public function getProducts(){
        $result = M()->table('product')->order('type asc')->select();
        $i = 0;
        foreach($result as $value){
            $data[$i]["id"] = $value["id"];
            $data[$i]["name"] = $value["name"];
            $data[$i]["price"] = $value["price"];
            $data[$i]["img"]  = C("APP_WEB").$value["img"];
            $data[$i]["type"]= $value["type"];
            $data[$i]["carrieroperator"] = $value["carrieroperator"];
            $data[$i]["color"] = $value["color"];
            $data[$i]["storage"]= $value["storage"];
            $i++;
        }
        echo json_encode($data);
    }

    public function findPassCheckPhoneExsit(){
        $phone = I('phone',-1,'htmlspecialchars');
        if($phone != null && $this->checkPhoneNumber($phone)){
            if($this->checkPhoneExist($phone)){
                echo "0200";
            }else{
                echo "0400";
            }
        }else{
            echo "data error";
        }
    }


    public function findPassUpdatePass(){
        $phone = I('phone',-1,'htmlspecialchars');
        $newPass = I('password',-1,'htmlspecialchars');
        if($this->checkPhoneNumber($phone)  &&  $newPass != null){
            $data['password'] = null;
            $result = M()->table('user')->where("phone = '".$phone."'")->save($data);
            if($result != null){
                $data['password'] = md5($newPass);
                $result = M()->table('user')->where("phone = '".$phone."'")->save($data);
                if($result != null){
                    echo "0200";
                }
            }else{
                echo "0404";
            }
        }else{
            echo "data error";
        }
    }


    public function login(){

         $phone =  I("phone",null);
         $password = I("password",null);

        if($password != null && $phone != null){

            if(!$this->checkPhoneExist($phone)){
                echo $this->PHONE_NO_EXIST;
                die;
            }

            if(!$this->checkUserLogin($password,$phone)){
                echo $this->LOGIN_PASSWORD_ERROR;
                die;
            }else{
                $userRusult = M()->table('user')->where("password = '".md5($password). "'&& phone='".$phone."'" )->find();
                $Realdata["uid"] = $userRusult["id"];
                if($userRusult["iconimg"]!= null){
                    $Realdata["iconImg"] = C("APP_WEB").$userRusult["iconimg"];
                }else{
                    $Realdata["iconImg"] = $userRusult["iconimg"];
                }
                $Realdata["signName"] = $userRusult["signname"];
                $Realdata["userName"]=$userRusult["username"];
                echo json_encode($Realdata);
                die;
            }

        }else{
            echo "error!";
        }

    }


    public function checkUserLogin($password,$phone){
        $userRusult = M()->table('user')->where("password = '".md5($password). "'&& phone='".$phone."'" )->find();
        if($userRusult != null){
            return true;
        }else{
            return false;
        }
    }

    public function checkPhoneNumber($mobile){
        if(preg_match("/^1[34578]\d{9}$/", $mobile)){
           return true;
        }else{
            return false;
        }
    }


    public function checkUserExist($userName=null,$id=0){

        if($userName != null){
            $userNameRusult = M()->table('user')->where("userName='".$userName."'")->find();
            if($userNameRusult != null){
                return true;
            }else{
                return false;
            }

        }else{
            if($id > 0){
                $userIdRusult = M()->table('user')->where("id='".$id."'")->find();
                if($userIdRusult != null){
                    return true;
                }else{
                    return false;
                }

            }
        }
    }

    public function checkPhoneExist($phoneNumber){
        $phoneRusult = M()->table('user')->where("phone='".$phoneNumber."'")->find();
        if($phoneRusult != null){
            return true;
        }else{
            return false;
        }
    }
}
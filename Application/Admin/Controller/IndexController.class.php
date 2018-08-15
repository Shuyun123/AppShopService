<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends CommonController
{

    public function index($tab = 1)
    {

        $this->getAppBannerImg();
        $this->getProductData();
        $this->getUserInfo();
        $this->getOrderInfo();
        $this->getUpdateAppInfo();

        if ($tab != null && is_numeric($tab)) {
            $this->assign("tab", $tab);
        } else {
            $this->assign("tab", $_GET["tab"]);
        }
        $this->display("index");
    }


    public function getOrderInfo()
    {

        $result = M()->table('buy')->join(' user on buy.uid = user.id')->join('product on buy.pid = product.id')->select();
        $idResult = M()->table('buy')->field('id')->select();
        if ($result != null && $idResult != null) {
            for ($i = 0; $i < count($idResult); $i++) {
                $result[$i]["id"] = $idResult[$i]["id"];
            }
            $this->assign('orderInfo', $result);
        }
    }


    public function changePayState()
    {
        $id = I('id', -1, 'htmlspecialchars');
        $tab = I('tab', 0, 'htmlspecialchars');
        $state = I('state', -1, 'htmlspecialchars');
        if ($state != -1 && $state == 0) {
            $state = 1;
        } elseif ($state != -1 && $state == 1) {
            $state = 0;
        } else {
            $this->error("更改出错");
        }
        $data['isPay'] = $state;
        $result = M()->table('buy')->where("id=$id")->save($data);
        if ($result != null) {
            $this->redirect("Index/index", array('tab' => $tab));
        } else {
            $this->error("更改出错");
        }
    }


    public function changeDeliverState()
    {
        $id = I('id', -1, 'htmlspecialchars');
        $tab = I('tab', 0, 'htmlspecialchars');
        $state = I('state', -1, 'htmlspecialchars');
        if ($state != -1 && $state == 0) {
            $state = 1;
        } elseif ($state != -1 && $state == 1) {
            $state = 0;
        }
        $data['isDeliver'] = $state;
        $result = M()->table('buy')->where("id=$id")->save($data);
        if ($result != null) {
            $this->redirect("Index/index", array('tab' => $tab));
        } else {
            $this->error("更改出错");
        }
    }


    public function getUserInfo()
    {

        $result = M()->table('user')->select();
        if ($result != null) {
            $this->assign('userInfo', $result);
        }
    }

    public function deleteProduct()
    {

        $id = I('id', -1, 'htmlspecialchars');
        $tab = I('tab', 0, 'htmlspecialchars');
        if ($id != null) {
            $result = M()->table('product')->where("id=$id")->delete();
            if ($result) {
                if ($tab != null && is_numeric($tab)) {
                    $this->redirect("Index/index", array('tab' => $tab));
                } else {
                    $this->redirect("Index/index");
                }
            }
        }
    }


    public function deleteBanner()
    {

        $id = I('id', -1, 'htmlspecialchars');
        $tab = I('tab', 0, 'htmlspecialchars');
        if ($id != null) {
            $result = M()->table('banner')->where("id=$id")->delete();
            if ($result) {
                if ($tab != null && is_numeric($tab)) {
                    $this->redirect("Index/index", array('tab' => $tab));
                } else {
                    $this->redirect("Index/index");
                }
            }
        }
    }

    public function getAppBannerImg()
    {

        $result = M()->table('banner')->select();
        if ($result != null) {
            $this->assign('banner', $result);
        }

    }


    public function getProductData()
    {

        $result = M()->table('product')->order('type asc')->select();
        if ($result != null) {
            $this->assign('product', $result);
        }

    }


    public function addProduct()
    {

        $productName = I('productName', null, 'htmlspecialchars');
        $price = I('price', 0, 'htmlspecialchars');
        $productType = I('type', 0, 'htmlspecialchars');
        $carrieroperator = I('carrieroperator', 0, 'htmlspecialchars');
        $color = I('color', 0, 'htmlspecialchars');
        $storage = I('storage', 0, 'htmlspecialchars');

        if ($productName == null) {
            echo "<script> alert('商品名称不能为空!');parent.location.href='index.html'; </script>";
            exit();
        } else {
            $productResult = M()->table('product')->where(array('name' => $productName, 'type' => $productType, 'color' => $color, 'storage' => $storage, 'carrieroperator' => $carrieroperator))->find();
            if ($productResult != null) {
                echo "<script> alert('该商品名已经添加过,请删除再添加!');parent.location.href='index.html'; </script>";
                exit();
            }
        }

        if ($price <= 0 || !is_numeric($price)) {
            echo "<script> alert('请填写商品的价格!');parent.location.href='index.html'; </script>";
            exit();
        }

        if ($_FILES['file']['size'] == 0) {
            echo "<script> alert('图片不能为空!');parent.location.href='index.html'; </script>";
            exit();
        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 20971520;// 设置附件上传大小
        $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
        // $upload->saveName  =     $productName;
        $upload->replace = true;
        $upload->rootPath = "./Uploads/";
        $upload->savePath = ""; // 设置附件上传目录
        $upload->subName = "img";
        $info = $upload->upload();

        if ($info) {
            $oldName = $info['file']['name'];
            $newName = $info['file']['savename'];
            $path = $info['file']['savepath'];

            if ($productType > 1) {
                $data['name'] = $productName;
                $data['price'] = $price;
                $data['type'] = $productType;
                $data['img'] = "/Uploads/" . $path . $newName;
                $data['carrieroperator'] = -1;
                $data['color'] = -1;
                $data['storage'] = -1;
            } else {
                $data['name'] = $productName;
                $data['price'] = $price;
                $data['type'] = $productType;
                $data['img'] = "/Uploads/" . $path . $newName;
                $data['carrieroperator'] = $carrieroperator;
                $data['color'] = $color;
                $data['storage'] = $storage;
            }

            $result = M()->table('product')->data($data)->add();

            if ($result) {
                echo "<script> alert('添加商品成功!');parent.location.href='index.html'; </script>";
                exit();
            } else {
                echo "<script> alert('添加商品失败!');parent.location.href='index.html'; </script>";
                exit();
            }
        } else {
            $this->error($upload->getError());
        }
    }

    public function dealData()
    {
        $pictureName = I('pictureName', null, 'htmlspecialchars');
        $id = I('id', 0, 'htmlspecialchars');
        $introduceImg = I('introduceImg', null, 'htmlspecialchars');


        if ($pictureName == null) {
            echo "<script> alert('图片名称不能为空!');parent.location.href='index.html'; </script>";
            exit();
        } else {

            $pictureResult = M()->table('banner')->where(array('name' => $pictureName))->find();
            if ($pictureResult != null) {
                echo "<script> alert('该图片名已经添加过,请删除再添加!');parent.location.href='index.html'; </script>";
                exit();
            }
        }

        if ($id <= 0 || !is_numeric($id)) {
            echo "<script> alert('请填写正确的图片id!');parent.location.href='index.html'; </script>";
            exit();
        }

        if ($introduceImg == null) {
            echo "<script> alert('图片描述不能为空!');parent.location.href='index.html'; </script>";
            exit();
        }

        if ($_FILES['file']['size'] == 0) {
            echo "<script> alert('图片不能为空!');parent.location.href='index.html'; </script>";
            exit();
        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 20971520;// 设置附件上传大小
        $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->replace = true;
        $upload->rootPath = "./Uploads/";
        $upload->savePath = ""; // 设置附件上传目录
        $upload->subName = "img";
        $info = $upload->upload();

        if ($info) {
            $oldName = $info['file']['name'];
            $newName = $info['file']['savename'];
            $path = $info['file']['savepath'];

            $data['name'] = $pictureName;
            $data['number'] = $id;
            $data['introduce'] = $introduceImg;
            $data['img'] = "/Uploads/" . $path . $newName;

            $result = M()->table('banner')->data($data)->add();

            if ($result) {
                echo "<script> alert('添加轮播图片成功!');parent.location.href='index.html'; </script>";
                exit();
            } else {
                echo "<script> alert('添加轮播图片失败!');parent.location.href='index.html'; </script>";
                exit();
            }
        } else {
            $this->error($upload->getError());
        }

    }


    public function getUpdateAppInfo()
    {
        $resultInfo = M()->table('updateapp')->order('updatetime desc')->select();
        $this->assign("appInfo", $resultInfo[0]);
    }


    public function uploadApp()
    {
        $appName = I('appName', null, 'htmlspecialchars');
        $versionCode = I('versionCode', 0, 'htmlspecialchars');
        $versionName = I('versionName', null, 'htmlspecialchars');
        $updateContent = I('updateContent', null, 'htmlspecialchars');


        if ($appName == null) {
            echo "<script> alert('请填写app名称!');parent.location.href='index/tab/7.html'; </script>";
            exit();

        }

        if ($versionCode == 0) {
            echo "<script> alert('请填写app版本代码号!');parent.location.href='index/tab/7.html'; </script>";
            exit();
        }

        $result = explode(".", $versionName);
        $versionNameNumber = $result[0] . $result[1];
        if (!is_numeric($versionNameNumber) || $versionNameNumber <= 10 || $versionNameNumber >= 100) {
            echo "<script> alert('请填写app版本名称!');parent.location.href='index/tab/7.html'; </script>";
            exit();
        }
        if ($_FILES['file']['size'] == 0) {
            echo "<script> alert('没有选择app!');parent.location.href='index/tab/7.html'; </script>";
            exit();
        }

        if (!is_numeric($versionCode)) {
            echo "<script> alert('请填写正确的app版本号!');parent.location.href='index/tab/7.html'; </script>";
            exit();
        }

        if ($this->checkVersion($versionCode)) {
            echo "<script> alert('该app版本号已经添加过!');parent.location.href='index/tab/7.html'; </script>";
            exit();
        }

        if ($updateContent == null) {
            echo "<script> alert('请填写app名称!');parent.location.href='index/tab/7.html'; </script>";
            exit();

        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->exts = array('apk', 'APK');// 设置附件上传类型
        $upload->replace = true;
        $upload->saveName = $appName;
        $upload->rootPath = "./Uploads/";
        $upload->savePath = ""; // 设置附件上传目录
        $upload->subName = "App";
        $info = $upload->upload();
        if ($info) {
            $oldName = $info['file']['name'];
            $newName = $info['file']['savename'];
            $path = $info['file']['savepath'];
            $data['appname'] = $appName;
            $data['versioncode'] = $versionCode;
            $data['updatetime'] = time();
            $data['apppath'] = $newName;
            $data['versionname'] = $versionName;
            $data['updatecontent'] = $updateContent;

            $result = M()->table('updateapp')->data($data)->add();
            if ($result) {
                echo "<script> alert('上传app成功!');parent.location.href='index/tab/7.html'; </script>";
                exit();
            } else {
                echo "<script> alert('上传app失败!');parent.location.href='index/tab/7.html'; </script>";
                exit();
            }
        } else {
            $this->error($upload->getError());
        }

    }


    public function checkVersion($version)
    {
        $userRusult = M()->table('updateapp')->where("versioncode = '" . $version . "'")->find();
        if ($userRusult != null) {
            return true;
        } else {
            return false;
        }
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        setcookie('remember', '', time() - 1);
        $this->display("Login/index");
    }


}

<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/lib/normalize.css">
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/lib/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/lib/flat-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/manage.css">
    <script type="text/javascript" src="/AppShopService/Public/Js/jquery.js"></script>
    <script src="/AppShopService/Public/Js/lib/require.js" data-main="/AppShopService/Public/Js/manage_main"></script>
    <script type="text/javascript">


        $("#fileUpload").live('change',function(){
            var file = String($("#fileUpload").val());
            var pos = file.lastIndexOf("\\");
            var fileName = file.substring(pos+1);
            var pos2 = file.lastIndexOf(".");
            var endStr = String(file.substring(pos2+1));
            if((endStr != "jpg") && (endStr != "jpeg") && (endStr != "png") && (endStr != "JPG") && (endStr != "JPEG") && (endStr != "PNG")){
                alert("图片格式不正确!");
                location.reload();
            }else{
                if(endStr == null){
                    alert("图片不能为空!");
                    location.reload();
                }else{
                    document.getElementById('displayName').innerHTML = fileName;
                }
            }
        });


        $("#fileUpload2").live('change',function(){
            var file = String($("#fileUpload2").val());
            var pos = file.lastIndexOf("\\");
            var fileName = file.substring(pos+1);
            var pos2 = file.lastIndexOf(".");
            var endStr = String(file.substring(pos2+1));
            if((endStr != "jpg") && (endStr != "jpeg") && (endStr != "png") && (endStr != "JPG") && (endStr != "JPEG") && (endStr != "PNG")){
                alert("图片格式不正确!");
                location.reload();
            }else{
                if(endStr == null){
                    alert("图片不能为空!");
                    location.reload();
                }else{
                    document.getElementById('displayName2').innerHTML = fileName;
                }
            }
        });


        $("#fileUpload3").live('change',function(){
            var file = String($("#fileUpload3").val());
            var pos = file.lastIndexOf("\\");
            var fileName = file.substring(pos+1);
            var pos2 = file.lastIndexOf(".");
            var endStr = String(file.substring(pos2+1));
            if((endStr != "apk") && (endStr != "APK")){
                alert("App格式不正确!");
                location.reload();
            }else{
                if(endStr == null){
                    alert("请选择App!");
                    location.reload();
                }else{
                    document.getElementById('displayName3').innerHTML = fileName;
                }
            }
        });


        $(document).ready(function(){
            $(".selectType").change(function(){
                //alert($(this).children('option:selected').val());
                var p1=$(this).children('option:selected').val();//这就是selected的值
                if(p1>1){
                    $("#product_detail").hide();
                }else{
                    $("#product_detail").show();
                }
            })
        })


    </script>
</head>
<body>
<div class="container-fluid" >
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading">选项</div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked nav-option">
                        <li class="<?php if(($tab == 1)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/1');?>">App轮播</a>
                        </li>
                        <li class="<?php if(($tab == 2)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/2');?>">添加轮播</a>
                        </li>
                        <li class="<?php if(($tab == 3)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/3');?>">商品列表</a>
                        </li>
                        <li class="<?php if(($tab == 4)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/4');?>">添加商品</a>
                        </li>
                        <li class="<?php if(($tab == 5)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/5');?>">用户列表</a>
                        </li>
                        <li class="<?php if(($tab == 6)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/6');?>">用户购买清单</a>
                        </li>

                        <li class="<?php if(($tab == 7)): ?>active<?php endif; ?>" role="presentation">
                            <a href="<?php echo U('/Admin/Index/index/tab/7');?>">上传新版本App</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div style="float:inherit;"><a href="<?php echo U('Index/index',array('tab'=>1));?>" style="color:white;">App商城后台管理</a></div>
                    <div style="float: right;margin-top: -25px;margin-right: 160px;">
                        用户名:<?php echo $_SESSION['username'];?>
                        <a href="<?php echo U('Index/logout');?>"><button style=";border: 5psolid #dedede;-moz-border-radius: 15px;-webkit-border-radius: 15px;border-radius:15px;  background: dodgerblue;color:white;">退出</button></a>
                    </div>
                </div>
                <div class="panel-body row">
                    <!--<div class="loading" ms-if="!loaded">loading.......</div>-->
                    <div class="list <?php if(($tab == 1)): ?>show<?php endif; ?>">
                        <div>
                            <div>
                                <table class="table table-hover">
                                    <tr>
                                        <th>图片名称</th>
                                        <th>图片id</th>
                                        <th>图片描述</th>
                                        <th>操作</th>
                                    </tr>
                                    <?php if(is_array($banner)): foreach($banner as $key=>$value): ?><tr>
                                            <td><?php echo ($value["name"]); ?> </td>
                                            <td><?php echo ($value["number"]); ?> </td>
                                            <td><?php echo ($value["introduce"]); ?> </td>
                                            <td><a href="<?php echo U('Index/deleteBanner',array('id'=>$value['id'],'tab'=>1));?>">删除</a></td>
                                        </tr><?php endforeach; endif; ?>
                                </table>
                            </div>
                            <ul class="pagination-plain">
                                <?php echo $show;?>
                            </ul>
                        </div>
                    </div>

                    <div class="add-item col-md-6 <?php if(($tab == 2)): ?>show<?php endif; ?>">
                        <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?php echo U('Index/dealData');?>" id="form">
                            <div class="form-group">
                                <label for="inputTitle" class="col-lg-2 control-label">图片名称</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputTitle" placeholder="图片名称" style="width:180px" name="pictureName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputNum" class="col-lg-2 control-label">图片id</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputNum" placeholder="图片id" style="width:180px" name="id">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="inputTitle" class="col-lg-2 control-label">图片描述</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputTime" placeholder="图片描述" style="width:180px" name="introduceImg">
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-lg-offset-2 col-lg-10">
                                        <input type="file" name="file" class="upload" id="fileUpload"/>
                                       <label id="displayName"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-default">确定</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="award-deatil <?php if(($tab == 3)): ?>show<?php endif; ?>">

                        <div>
                            <table class="table table-hover">
                                <tr>
                                    <th>商品名称</th>
                                    <th>商品价格</th>
                                    <th>商品类别</th>
                                    <th>运营商</th>
                                    <th>颜色</th>
                                    <th>内存</th>
                                    <th>操作</th>
                                </tr>

                                <?php if(is_array($product)): foreach($product as $key=>$value): ?><tr>
                                        <td><?php echo ($value["name"]); ?> </td>
                                        <td><?php echo ($value["price"]); ?> </td>
                                        <td>
                                            <?php if(($value["type"] == 0)): ?>全新手机
                                                <?php elseif($value["type"] == 1): ?> 二手良品
                                                <?php elseif($value["type"] == 2): ?> 手机配件
                                                <?php else: ?> 手机壳/膜<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(($value["carrieroperator"] == 0)): ?>移动4G
                                                <?php elseif($value["carrieroperator"] == 1): ?> 联通4G
                                                <?php elseif($value["carrieroperator"] == 2): ?> 电信4G
                                                <?php elseif($value["carrieroperator"] == 3): ?> 全网通
                                                <?php else: ?> ---<?php endif; ?>


                                        </td>
                                        <td>
                                            <?php if(($value["color"] == 0)): ?>深空灰
                                                <?php elseif($value["color"] == 1): ?> 银色
                                                <?php elseif($value["color"] == 2): ?> 香槟金
                                                <?php elseif($value["color"] == 3): ?> 玫瑰金
                                                <?php elseif($value["color"] == 4): ?> 黑色
                                                <?php elseif($value["color"] == 5): ?> 白色
                                                <?php else: ?> ---<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(($value["storage"] == 0)): ?>16G
                                                <?php elseif($value["storage"] == 1): ?> 32G
                                                <?php elseif($value["storage"] == 2): ?> 64G
                                                <?php elseif($value["storage"] == 3): ?> 128G
                                                <?php else: ?> ---<?php endif; ?>
                                        </td>
                                        <td><a href="<?php echo U('Index/deleteProduct',array('id'=>$value['id'],'tab'=>3));?>">删除</a></td>
                                    </tr><?php endforeach; endif; ?>
                            </table>
                        </div>
                    </div>

                    <div class="award-deatil <?php if(($tab == 4)): ?>show<?php endif; ?>">


                        <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?php echo U('Index/addProduct');?>" id="form">
                            <div class="form-group">
                                <label for="inputTitle" class="col-lg-2 control-label">商品名称</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputTitle" placeholder="商品名称" style="width:180px" name="productName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputNum" class="col-lg-2 control-label">商品价格</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputNum" placeholder="商品价格" style="width:180px" name="price">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputNum" class="col-lg-2 control-label">商品类别</label>
                                <label id="lblSelect" style="margin-left: 16px">
                                    <select id="selectPoint" name="type" class="selectType">
                                        <option value ="0">全新手机</option>
                                        <option value ="1">二手良品</option>
                                        <option value="2">手机配件</option>
                                        <option value="3">手机壳/膜</option>
                                    </select>
                                </label>
                            </div>
                            <div id="product_detail" style="display: block">
                                <div class="form-group" >
                                    <label for="inputNum" class="col-lg-2 control-label">运营商</label>
                                    <label id="lblSelect" style="margin-left: 16px">
                                        <select id="selectPoint" name="carrieroperator">
                                            <option value ="0">移动4G</option>
                                            <option value ="1">联通4G</option>
                                            <option value="2">电信4G</option>
                                            <option value="3">全网通</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group" >
                                    <label for="inputNum" class="col-lg-2 control-label">颜色</label>
                                    <label id="lblSelect" style="margin-left: 16px">
                                        <select id="selectPoint" name="color">
                                            <option value ="0">深空灰</option>
                                            <option value ="1">银色</option>
                                            <option value="2">香槟金</option>
                                            <option value="3">玫瑰金</option>
                                            <option value="4">黑色</option>
                                            <option value="5">白色</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group" >
                                    <label for="inputNum" class="col-lg-2 control-label">内存</label>
                                    <label id="lblSelect" style="margin-left: 16px">
                                        <select id="selectPoint" name="storage">
                                            <option value ="0">16G</option>
                                            <option value ="1">32G</option>
                                            <option value="2">64G</option>
                                            <option value="3">128G</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="file" name="file" class="upload" id="fileUpload2"/>
                                        <label id="displayName2"></label>
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-default">确定</button>
                                </div>
                            </div>

                        </form>

                    </div>


                    <div class="award-deatil <?php if(($tab == 5)): ?>show<?php endif; ?>">

                        <div>
                            <table class="table table-hover">
                                <tr>
                                    <th>用户id</th>
                                    <th>用户名称</th>
                                    <th>用户电话</th>
                                    <th>注册时间</th>
                                </tr>

                                <?php if(is_array($userInfo)): foreach($userInfo as $key=>$value): ?><tr>
                                        <td><?php echo ($value["id"]); ?> </td>
                                        <td><?php echo ($value["username"]); ?></td>
                                        <td><?php echo ($value["phone"]); ?></td>
                                        <td><?php echo (date("Y-m-d H:i:s",$value["logintime"])); ?></td>

                                    </tr><?php endforeach; endif; ?>
                            </table>
                        </div>
                    </div>

                    <div class="award-deatil <?php if(($tab == 6)): ?>show<?php endif; ?>">

                        <div>
                            <table class="table table-hover">
                                <tr>
                                    <th>购买用户</th>
                                    <th>商品名称</th>
                                    <th>商品单价</th>
                                    <th>商品类别</th>
                                    <th>运营商</th>
                                    <th>颜色</th>
                                    <th>内存</th>
                                    <th>购买数量</th>
                                    <th>应付款额</th>
                                    <th>是否付款</th>
                                    <th>是否发货</th>
                                    <th>是否评价</th>
                                </tr>

                                <?php if(is_array($orderInfo)): foreach($orderInfo as $key=>$value): ?><tr>

                                        <td><?php echo ($value["username"]); ?> </td>
                                        <td><?php echo ($value["name"]); ?> </td>
                                        <td><?php echo ($value["price"]); ?> </td>
                                        <td>
                                            <?php if(($value["type"] == 0)): ?>全新手机
                                                <?php elseif($value["type"] == 1): ?> 二手良品
                                                <?php elseif($value["type"] == 2): ?> 手机配件
                                                <?php else: ?> 手机壳/膜<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(($value["carrieroperator"] == 0)): ?>移动4G
                                                <?php elseif($value["carrieroperator"] == 1): ?> 联通4G
                                                <?php elseif($value["carrieroperator"] == 2): ?> 电信4G
                                                <?php elseif($value["carrieroperator"] == 3): ?> 全网通
                                                <?php else: ?> ---<?php endif; ?>

                                        </td>
                                        <td>
                                            <?php if(($value["color"] == 0)): ?>深空灰
                                                <?php elseif($value["color"] == 1): ?> 银色
                                                <?php elseif($value["color"] == 2): ?> 香槟金
                                                <?php elseif($value["color"] == 3): ?> 玫瑰金
                                                <?php elseif($value["color"] == 4): ?> 黑色
                                                <?php elseif($value["color"] == 5): ?> 白色
                                                <?php else: ?> ---<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(($value["storage"] == 0)): ?>16G
                                                <?php elseif($value["storage"] == 1): ?> 32G
                                                <?php elseif($value["storage"] == 2): ?> 64G
                                                <?php elseif($value["storage"] == 3): ?> 128G
                                                <?php else: ?> ---<?php endif; ?>
                                        </td>
                                        <td><?php echo ($value["sum"]); ?> </td>
                                        <td style="color: red"><?php echo ($value["total"]); ?></td>
                                        <td style="color: red">
                                            <?php if(($value["ispay"] == 0)): ?>待付款
                                                <?php elseif(($value["ispay"] == 1)): ?> 已付款<?php endif; ?>
                                            <a href="<?php echo U('Index/changePayState',array('id'=>$value['id'],'state'=>$value['ispay'],'tab'=>6));?>">|&nbsp&nbsp操作</a>
                                        </td>
                                        <td style="color: red">
                                            <?php if(($value["isdeliver"] == 0)): ?>待发货
                                                <?php elseif(($value["isdeliver"] == 1)): ?> 已发货<?php endif; ?>
                                            <a href="<?php echo U('Index/changeDeliverState',array('id'=>$value['id'],'state'=>$value['isdeliver'],'tab'=>6));?>">|&nbsp&nbsp操作</a>
                                        </td>
                                        <td style="color: red">
                                            <?php if(($value["iscomment"] == 0)): ?>待评价
                                                <?php elseif(($value["iscomment"] == 1)): ?> 已评价<?php endif; ?>
                                        </td>
                                    </tr><?php endforeach; endif; ?>
                            </table>
                        </div>
                    </div>


                    <div class="award-deatil <?php if(($tab == 7)): ?>show<?php endif; ?>">

                        <div>
                            <table class="table table-hover">
                                <tr>
                                    <th colspan="2">最新版本app</th>
                                    <th>app名称: <?php echo $appInfo["appname"]?></th>
                                    <th>app版本代码号: <?php echo $appInfo["versioncode"]?></th>
                                    <th>app版本名称: <?php echo $appInfo["versionname"]?></th>
                                </tr>
                            </table>
                        </div>
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="<?php echo U('Index/uploadApp');?>" id="form">
                            <div class="form-group">
                                <label for="inputTitle" class="col-lg-2 control-label">App名称</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputTitle" placeholder="App名称" style="width:180px" name="appName">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputNum" class="col-lg-2 control-label">App版本代码号</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputNum" placeholder="如:2" style="width:180px" name="versionCode">
                                </div>
                            </div>

                             <div class="form-group">
                               <label for="inputNum" class="col-lg-2 control-label">App版本名称</label>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" id="inputNum" placeholder="如:1.2" style="width:180px" name="versionName">
                                </div>
                            </div>

                           <div class="form-group">
                               <label for="inputNum" class="col-lg-2 control-label">更新内容</label>
                               <div class="col-lg-10">
                                   <textarea name="updateContent" cols="25" rows="8"></textarea>
                               </div>
                           </div>


                            <div class="form-group">

                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="file" name="file" class="uploadApp" id="fileUpload3"/>
                                    <label id="displayName3"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-default">确定</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
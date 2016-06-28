<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/lib/normalize.css">
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/lib/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/lib/flat-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/AppShopService/Public/Css/login.css">
    <script src="/AppShopService/Public/Js/lib/require.js" data-main="/AppShopService/Public/Js/login_main"></script>

</head>
<body class="background">
<div class="wrapper">
    <form class="form-inline" role="form" method="POST" action="<?php echo U('Login/dealData');?>">
        <div class="form-group">
            <input name ="username" type="text" class="form-control" id="inputUserName" placeholder="用户名">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" id="exampleInputPassword2" placeholder="密码">
        </div>
        <div class="form-group">
            <label class="checkbox" for="checkbox2">
                <input type="checkbox" name="checkbox" data-toggle="checkbox" value="1" id="checkbox2" >
                <font color="white">记住我</font>
            </label>
        </div>
        <button type="submit" class="btn btn-default">登录</button>
    </form>
</div>
</body>
</html>
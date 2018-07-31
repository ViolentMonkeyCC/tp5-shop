<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"H:\phpStudy\PHPTutorial\WWW\local.shop.com\public/../application/admin\view\role\add.html";i:1533046264;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
    <style>
        .active{
            border-bottom: solid 3px #66c9f3;
        }
    </style>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle">
            <span class="active">分配权限</span>

        </div>
        <form action="<?php echo url('/admin/role/add'); ?>" method="post">
            <ul class="forminfo">
                <li>
                    <label>角色名称</label>
                    <input name="auth_name" placeholder="请输入角色名称" type="text" class="dfinput" />
                </li>

            </ul>
			<li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
             </li>
        </form>
    </div>
</body>
<script>

</script>
</html>

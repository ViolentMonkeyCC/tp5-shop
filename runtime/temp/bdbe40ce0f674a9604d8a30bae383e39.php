<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"H:\phpStudy\PHPTutorial\WWW\local.shop.com\public/../application/admin\view\type\upd.html";i:1533203812;}*/ ?>
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
            <span class="active">编辑用户</span>

        </div>
        <form action="<?php echo url('/admin/type/upd'); ?>" method="post">
            <input type="hidden" name="type_id" value="<?php echo $typeData['type_id']; ?>">
            <ul class="forminfo">
                <li>
                    <label>类型名称</label>
                    <input name="type_name" placeholder="请输入类型名称" value="<?php echo $typeData['type_name']; ?>" type="text" class="dfinput" />
                </li>
                <li>
                    <label>类型描述</label>
                    <input name="mark" placeholder="请输入商品类型描述" value="<?php echo $typeData['mark']; ?>" type="text" class="dfinput" />
                </li>
            </ul>
			<li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
             </li>
        </form>
    </div>
</body>
</html>

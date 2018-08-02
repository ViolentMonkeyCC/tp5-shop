<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:93:"H:\phpStudy\PHPTutorial\WWW\local.shop.com\public/../application/admin\view\category\upd.html";i:1533202683;}*/ ?>
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
            <span class="active">编辑分类</span>

        </div>
        <form action="<?php echo url('/admin/category/upd'); ?>" method="post">
            <input type="hidden" name="cat_id" value="<?php echo $catData['cat_id']; ?>">
            <ul class="forminfo">
                <li>
                    <label>分类名称</label>
                    <input name="cat_name" placeholder="请输入分类名称" value="<?php echo $catData['cat_name']; ?>" type="text" class="dfinput" />
                </li>
                <li>
                    <label>所属父分类</label>
                    <select name="pid" class="dfinput">
                        <option value="">请选择父分类</option>
                        <option value="0">顶级分类</option>
                        <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): if( count($cats)==0 ) : echo "" ;else: foreach($cats as $key=>$cat): ?>
                            <option value="<?php echo $cat['cat_id']; ?>"><?php echo str_repeat('&nbsp', $cat['level']*3); ?><?php echo $cat['cat_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>导航栏</label>
                    <input name="is_show" type="radio" value="4" checked="checked" />显示
                    <input name="is_show" type="radio" value="5" />不显示
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
    $("select[name='pid']").val("<?php echo $catData['pid']; ?>");
    var is_show = "<?php echo $catData['is_show']; ?>";
    $("input[value="+ is_show +"]").prop('checked', true);

</script>
</html>

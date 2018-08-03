<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"H:\phpStudy\PHPTutorial\WWW\local.shop.com\public/../application/admin\view\goods\add.html";i:1533301909;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/plugins/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/plugins/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/static/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
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
            <span class="active">基本信息</span>
            <span>商品属性信息</span>
            <span>商品相册</span>
            <span>商品描述</span>

        </div>
        <form action="<?php echo url('/admin/goods/add'); ?>" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品名称</label>
                    <input name="goods_name" placeholder="请输入商品名称" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品价格</label>
                    <input name="goods_price" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i>
                </li>
                <li>
                    <label>商品库存</label>
                    <input name="goods_number" placeholder="请输入商品库存" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品分类</label>
                    <select name="cat_id" class="dfinput">
                        <option value="">请选择商品分类</option>
                        <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): if( count($cats)==0 ) : echo "" ;else: foreach($cats as $key=>$cat): ?>
                            <option value="<?php echo $cat['cat_id']; ?>"><?php echo str_repeat('&nbsp', $cat['level']*3); ?><?php echo $cat['cat_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>回收站</label>
                    <input type="radio" name="is_delete" value="0" checked="checked">否&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="is_delete" value="1">是
                </li>
                <li>
                    <label>是否上架</label>
                    <input type="radio" name="is_sale" value="0">否&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="is_sale" value="1" checked="checked">是
                </li>
                <li>
                    <label>是否新品</label>
                    <input type="radio" name="is_new" value="0">否&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="is_new" value="1" checked="checked">是
                </li>
                <li>
                    <label>是否热卖</label>
                    <input type="radio" name="is_hot" value="0">否&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="is_hot" value="1" checked="checked">是
                </li>
                <li>
                    <label>是否推荐</label>
                    <input type="radio" name="is_best" value="0">否&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="is_best" value="1" checked="checked">是
                </li>
                
            </ul>
            <ul class="forminfo">
                <li>
                    <label>商品属性</label>
                    <select name="type_id" class="dfinput">
                        <option value="">请选择商品类型</option>
                        <?php if(is_array($types) || $types instanceof \think\Collection || $types instanceof \think\Paginator): if( count($types)==0 ) : echo "" ;else: foreach($types as $key=>$type): ?>
                        <option value="<?php echo $type['type_id']; ?>"><?php echo $type['type_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
            </ul>
            <ul class="forminfo">
                <li>
                    <a href="javascript:;" onclick="cloneImg(this)">[+]</a>&nbsp;&nbsp;<input name="img[]" type="file">
                </li>
            </ul>
            <ul class="forminfo">
                <li>
                    <label>商品描述</label>
                    <textarea name="goods_desc" id="goods_desc"></textarea>
                </li>
                
                <!--
                <li><label>是否审核</label><cite><input name="" type="radio" value="" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="radio" value="" />否</cite></li>
                -->
            </ul>
			<li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
             </li>
        </form>
    </div>
</body>
<script>
    //切换类型,获取属性
    $("select[name='type_id']").on('change', function () {
        //获取到选择的类型type_id的值
        var type_id = $(this).val();
        //发送ajax,获取指定类型的所有的属性
        $.get("<?php echo url('/admin/goods/getTypeAttr'); ?>", {"type_id":type_id}, function (res) {
            console.log(res);
        }, 'json');
    });

    //克隆图片上传框,进行多图上传
    function cloneImg(ele) {
        var text = $(ele).html();
        if (text == "[+]") {
            //克隆父元素li,并把a标签的[+]变为[-]
            var newLi = $(ele).parent().clone();
            newLi.children('a').html("[-]");
            //清空已上传的文件
            newLi.children('input').val('');
            //把newLi追加到当前元素的父元素的后面
            $(ele).parent().after(newLi);
        }else {
            //值是[-]把当前父元素li给移除
            $(ele).parent().remove();
        }
    }


    //初始化富文本编辑器
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('goods_desc');

    $(".formtitle span").click(function(event){
        $(this).addClass('active').siblings("span").removeClass('active') ;
        var index = $(this).index();
        $("ul.forminfo").eq(index).show().siblings(".forminfo").hide();
    });
     $(".formtitle span").eq(0).click();
</script>

</html>

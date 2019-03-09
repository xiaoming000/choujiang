<!DOCTYPE html>
<html>
<head>
    <!-- 新 Bootstrap4 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <!-- popper.min.js 用于弹窗、提示、下拉菜单 -->
    <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
    <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'public/css/Huploadify.css' ?>"/>
    <script type="text/javascript" src="<?php echo base_url().'public/js/jquery.Huploadify.js' ?>"></script>
    <title>抽奖</title>
    <script type="text/javascript">
        $(function () {
            // 上传图片
            $('#upload').Huploadify({
                auto:true,
                fileTypeExts:'*.jpg;*.png;*.gif',
                multi:true,
                formData:{},
                fileSizeLimit:9999,
                showUploadedPercent:true,//是否实时显示上传的百分比，如20%
                showUploadedSize:true,
                removeTimeout:9999999,
                uploader:"<?php echo site_url('Xxm/upload_img') ?>",
                onUploadComplete:function(file,res){
                    var imgs = "<img height='100' src='" + "<?php echo base_url();?>" +res+"'>";
                    $("#img").val(res);
                    $("#img-display").append(imgs);
                },
            });
        });
    </script>
</head>
<body>
<div class="container border" style="margin-top: 50px;">
    <form role="form" method="post" action="http://localhost/shopapi/index.php/Xxm/choujiang_update">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" id="img" name="img" value="">
        <div class="form-group">
            <label for="name">商品名称</label>
            <input type="text" class="form-control" name="goods" value="<?php echo $goods;?>" placeholder="请输入商品名称">
        </div>
        <div class="form-group">
            <label for="name">中奖概率</label>
            <input type="text" class="form-control" name="value" value="<?php echo $value;?>" placeholder="请输入商品名称">
        </div>
        <div id="img-display">
            <?php if ($img): ?>
            <img src="<?php echo base_url().$img ?>" height="100px">
            <?php endif; ?>
        </div>
        <div id="upload"></div>
        <div style="text-align: center;">
            <button type="submit" class="btn btn-lg btn-default">提交</button>
        </div>
    </form></div>


    <!--  图片上传-->
<!--    <div id="success-img"></div>-->
</body>
</html>
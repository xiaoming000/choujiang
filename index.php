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
    <title>抽奖</title>
    <style>
        .link{
            color: #444;
            text-decoration: none;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $(".del").click(function () {
                $("#tr-"+$(this).attr('data-id')).remove();
                if (confirm("确定要删除吗？")){
                    $.post("<?php echo site_url('Xxm/choujiang_del') ?>",
                        {
                            id:$(this).attr('data-id')
                        },
                        function (data) {
                            // $("#tr-"+$(this).attr('data-id')).remove();
                            // alert(data);
                        }
                    );
                }
            });
        });
    </script>
</head>
<body>
<div class="container border" style="margin-top: 50px;">
    <div style="padding: 10px 100px;font-size: 24px;">
        <button id="add" class="btn-lg">
            <a class="link" href="<?php echo site_url('Xxm/choujiang_create') ?>">添加商品</a>
        </button>
    </div>
    <table class="table" style="text-align: center;">
        <thead>
            <tr>
                <th>id</th>
                <th>商品</th>
                <th>概率</th>
                <th>图片</th>
                <th colspan="2">操作</th>
            </tr>
        </thead>
        <tbody id="tbody">
        <?php foreach ($goods as $key=>$item):?>
            <tr id="tr-<?php echo $item['id'];?>">
                <td><?php echo $item['id'];?></td>
                <td><?php echo $item['goods'];?></td>
                <td><?php echo $item['value'];?></td>
                <td><img src="<?php echo base_url().$item['img'] ?>" height="100px"></td>
                <td>
                    <button class="btn update">
                        <a class="link" href="<?php echo site_url('Xxm/choujiang_create').'?id='.$item['id'].'&goods='.$item['goods'].'&value='.$item['value'].'&img='.$item['img']; ?>"> 修改</a>
                    </button>
                </td>
                <td>
                    <button class="btn del" id="del-<?php echo $item['id'];?>" data-id="<?php echo $item['id'];?>">删除</button>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
</body>
</html>



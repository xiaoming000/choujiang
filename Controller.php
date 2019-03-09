<?php

// 抽奖展示
public function choujiang(){
    $this->load->model('Redis_model');
    $res = $this->Redis_model->get("choujiang");
    if (!$res){
        $goods = $this->db->query("select * from ecs_choujiang order by `value`")->result_array();
        $res = json_encode($goods);
    }else{
        $res = json_decode($res,true);
    }
    for ($i=1;$i<=count($res);$i++){
        $res[$i-1]['value'] = $i;
    }
    var_dump($res);
}

// 抽奖後台管理展示
public function choujiang_admin(){
    $this->load->model('Redis_model');
    $res = $this->Redis_model->get("choujiang");
    $goods = json_decode($res,true);
    if (!empty($goods)){
        $data['goods'] = $goods;
    }else{
        $goods = $this->db->query("select * from ecs_choujiang order by `value`")->result_array();
        // 更新redis数据
        $this->load->model('Xxm_model');
        $this->Xxm_model->choujiang_redis_update();
        $data['goods'] = $goods;
    }
    $this->load->view('choujiang/index', $data);
}

// 抽奖
public function choujiang_apply(){
    $this->load->model('Redis_model');
    $res = $this->Redis_model->get("choujiang");
    if ($res){
        $goods = json_decode($res,true);
    }else{
        $goods = $this->db->query("select * from ecs_choujiang order by `value`")->result_array();
    }
    $prize_arr = $goods;
    // 获取需要精确的位数
    $precision = 0;
    $arr = array();
    $last = 0;
    foreach ($prize_arr as $key => $val) {
        // 设置精确度
        $num = explode('.', $val['value']);
        if (count($num) >= 1){
            $precise = strlen($num[1]);
            if ($precise > $precision){
                $precision = $precise;
            }
        }
        $arr[$key] = $val['value'];
        $last += $val['value'];
    }
    $rand_num = mt_rand()/mt_getrandmax()*pow(10,$precision+2);
    $sum = 0;
    foreach ($arr as $key=>$value){
        if ($rand_num < $sum + $value*pow(10,$precision)) {
            $res = $key;
            $prize_arr[$res]['value'] = "";
            $result = $prize_arr[$res];
            $this -> _tojson('1', '抽奖结果！', $result);
            break;
        } else {
            $sum += $value*pow(10,$precision);
        }
    }
}

// 抽奖修改展示
public function choujiang_create(){
    $id = $this->_values['id'];
    $goods = $this->_values['goods'];
    $value = $this->_values['value'];
    $img = $this->_values['img'];
    $data = array(
        'id'=>$id,
        'goods'=>$goods,
        'value'=>$value,
        'img'=>$img
    );
    $this->load->view('choujiang/update', $data);
}

// 抽奖修改
public function choujiang_update()
{
    $id = $this->_values['id'];
    $goods = $this->_values['goods'];
    $v = $this->_values['value'];
    $img = $this->_values['img'];
    // 修改数据库
    if ($id){ // 修改
        if ($img){
            $this->db->query("update ecs_choujiang set `goods`='$goods',`value`=$v,`img`='$img' where `id`=$id");
        }else{
            $this->db->query("update ecs_choujiang set `goods`='$goods',`value`=$v where `id`=$id");
        }
    }else{ // 增加
        if ($img){
            $this->db->query("INSERT INTO `ecs_choujiang` (`id`, `goods`, `value`, `type`, `img`) VALUES (NULL, '$goods', '$v', '0', '$img')");
        }else{
            $this->db->query("INSERT INTO `ecs_choujiang` (`id`, `goods`, `value`, `type`) VALUES (NULL, '$goods', '$v', '0')");
        }
    }
    $this->load->model('Xxm_model');
    $res = $this->Xxm_model->choujiang_redis_update();
    if ($res['code'] == 0){
        echo "redis换成更新失败！";
    }else{
        redirect("Xxm/choujiang_admin","修改成功！");
    }
}

// 图片上传
public function upload_img(){
    $filename = $_FILES['file']['name'];
    if ($filename) {
        move_uploaded_file($_FILES["file"]["tmp_name"], "./public/upload_img/".$filename);
        echo "public/upload_img/".$filename;
    }
}

// 抽奖删除
public function choujiang_del(){
    $id = $this->_values['id'];
    $this->db->query("delete from ecs_choujiang where id=$id");
    $this->load->model('Xxm_model');
    $res = $this->Xxm_model->choujiang_redis_update();
    if ($res['code'] == 0){
        echo "修改失败！";
    }else{
        echo "删除成功！";
    }
}

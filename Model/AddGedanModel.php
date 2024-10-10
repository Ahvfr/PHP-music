<?php

require_once('MysqlModel.php');
require_once('PublicModel.php');
class AddGedanModel{
    public function AddGedan(){
        $mysql = new mysql();
        return $mysql->AddGedan();
    }
    public function AddGedanAction($user){
        $mysql = new mysql();

        $imagepath = "../static/images/用户歌单_3.png";
        if($_FILES["upload_image"]["name"]){
            $allowedExts = array("jpg", "jpeg", "gif", "png");
            $temp = explode(".", $_FILES["upload_image"]["name"]);
            $extension = end($temp);
            if (!in_array($extension, $allowedExts)) {
                die("<script>alert('图片类型错误');window.location.replace('./?a=AddGedan');</script>");
            }
            move_uploaded_file($_FILES["upload_image"]["tmp_name"], "./static/images/" . $_POST["gedanname"] . "." . $extension);
            $imagepath = "../static/images/" . $_POST["gedanname"] . "." . $extension;
        }

        return $mysql -> AddGedanAction($imagepath,$user);


    }
}

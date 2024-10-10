<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class ChangeInfoModel {

    public function ChangeUserInfo($name,$user) {
        $mysql = new mysql();
        if($_FILES["upload_image"]["name"])
        {
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["upload_image"]["name"]);
            $extension = end($temp);
            $user->txpath = "../static/images/" . decrypt($_COOKIE['user']) . "." . $extension;
            //phpinfo();
            if(in_array($extension, $allowedExts))
            {
                move_uploaded_file($_FILES["upload_image"]["tmp_name"], APP_PATH . "static/images/" . decrypt($_COOKIE['user']) . "." . $extension);
                //phpinfo();

            }
        }


        return $mysql->changeUserInfo($name,$user);
    }
}
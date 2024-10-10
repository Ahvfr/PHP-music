<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class AddMessageModel {

    public function AddMessage($content,$gedan,$cookie) {
        $mysql = new mysql();
        return $mysql->AddMessage($content,$gedan,$cookie);
    }
    public function CheckUser($user) {
        $mysql = new mysql();
        $res = $mysql->getUserInfo($user);
        return $res;
    }

    public function AddMessage_re($content,$id,$cookie,$gedan) {
        $mysql = new mysql();
        return $mysql->AddMessage_re($content,$id,$cookie,$gedan);
    }
}
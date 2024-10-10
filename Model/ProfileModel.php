<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class ProfileModel {
    
    public function getUserInfo($user) {
        $mysql = new mysql();
        $res = $mysql->getUserInfo($user);
        $data = new user();
        $data->id = $res[0];
        $data->txpath = $res[3];
        $data->nickname = $res[4];
        $data->phone = $res[5];
        $data->gxqm = $res[6];
        $data->zcsj = $res[7];
        $data->email = $res[8];
        $data->type = $res[9];
        return $data;
    }
}
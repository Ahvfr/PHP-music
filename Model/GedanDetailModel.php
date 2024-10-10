<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class GedanDetailModel {

    public function GetGedanDetail($id) {
        $mysql = new mysql();
        $res = $mysql->GetGedanDetail($id);
        $mysql->AddGedanHit($id,$res['gedan'][6]);
        return $res;
    }
}
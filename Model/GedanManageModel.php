<?php

require_once('MysqlModel.php');
require_once('PublicModel.php');

class GedanManageModel{
    public function GedanManage($user){
        $mysql = new mysql();
        return $mysql->GedanManage($user);
    }

    public function GedanManage_ac($user){
        $mysql = new mysql();
        $mysql->GedanManage_ac($user);
    }

    public function GedanManage_del($user){
        $mysql = new mysql();
        $mysql ->GedanManage_del($user);
    }

}

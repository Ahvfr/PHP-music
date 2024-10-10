<?php

require_once('MysqlModel.php');
require_once('PublicModel.php');
class CommManageMod{
    public function CommManage($user){
        $mysql = new mysql();
        return $mysql->CommManage($user);
    }

    public function CommManage_1($user){
        $mysql = new mysql();
        return $mysql->CommManage_1($user);
    }

}
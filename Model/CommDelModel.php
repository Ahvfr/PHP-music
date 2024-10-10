<?php

require_once('MysqlModel.php');
require_once('PublicModel.php');

class CommDelModel{
    public function CommDel($user){
        $mysql = new mysql();
        $mysql->CommDel($user);
    }
}
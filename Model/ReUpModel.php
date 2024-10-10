<?php

require_once('MysqlModel.php');
require_once('PublicModel.php');

class ReUpModel{
    public function ReUp(){
        $mysql = new mysql();
        $mysql->ReUp();
    }
}
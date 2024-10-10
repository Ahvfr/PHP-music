<?php


require_once('MysqlModel.php');

class UploadChuliModel{
        public function UploadChuli($audiopath,$uid){
            $mysql = new mysql();
            return $mysql->UploadChuli($audiopath,$uid);

        }
}

<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class PlayMusicModel {

    public function GetMusicPath($id) {
        $mysql = new mysql();
        $res = $mysql->GetMusicPath($id);
        $mysql->AddMusicHit($id,$res[8]);
        return $res;
    }
}
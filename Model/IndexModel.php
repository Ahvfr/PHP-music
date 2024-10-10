<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class IndexModel {

    public function getDaily() {
        $mysql = new mysql();
        $res = $mysql->getDaily();
        $data = array();
        for ($i = 0 ; $i < 4 ; $i++) {
            $data[$i] = new song();
            $data[$i]->id = $res[$i][0];
            $data[$i]->name = $res[$i][1];
            $data[$i]->author = $res[$i][2];
            $data[$i]->imgPath = $res[$i][3];
            $data[$i]->time = $res[$i][4];
            $data[$i]->lyric = $res[$i][5];
            $data[$i]->audioPath = $res[$i][6];
            $data[$i]->gedan = $res[$i][7];
        }
        return $data;
    }

    public function getGedan() {
        $mysql = new mysql();
        $res = $mysql->getGedan();
        $data = array();
        for ($i = 0 ; $i < 4 ; $i++) {
            $data[$i] = new gedan();
            $data[$i]->id = $res[$i][0];
            $data[$i]->name = $res[$i][1];
            $data[$i]->author = $res[$i][2];
            $data[$i]->imgPath = $res[$i][3];
            $data[$i]->intro = $res[$i][4];
            $data[$i]->type = $res[$i][5];
        }
        return $data;
    }


}
<?php
require_once('MysqlModel.php');
require_once('PublicModel.php');

class BangdanModel{
    public function getBangdan() {
        $bangdan = array('rgb','ndb','rhb');
        $bangdanCn = array('rgb'=>'热歌榜','ndb'=>'内地榜','rhb'=>'日韩榜');
        $mysql = new mysql();
        $res = $mysql->getBangdan();
        $data = array();

        for ($i = 0 ; $i < count($bangdan) ; $i++){
            $data[$i] = new bangdan();
            $data[$i]->name = $bangdanCn[$bangdan[$i]];
            $data[$i]->music = array();
            for ($j = 0 ; $j < count($res[$bangdan[$i]]) ; $j++){
                $data[$i]->music[$j] = new song();
                $data[$i]->music[$j]->id = $res[$bangdan[$i]][$j][0];
                $data[$i]->music[$j]->name = $res[$bangdan[$i]][$j][1];
                $data[$i]->music[$j]->author = $res[$bangdan[$i]][$j][2];
                $data[$i]->music[$j]->time = $res[$bangdan[$i]][$j][4];
            }
        }
        //var_dump($data);
        //die();
        return $data;
    }
}
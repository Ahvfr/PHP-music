<?php


class IndexModel{

    public function Index(){
        $conn = $this ->SqlConn();
        $arr = array("gedan","message","music","user");
        $result = array();
        foreach($arr as $num => $value){
            $sql = "SELECT count(*) FROM " . $value ;
            $result[$num] = mysqli_fetch_all($conn -> query($sql))[0][0];
        }
        return $result;

    }

    public function CheckLogin(){

        if($_COOKIE["admin"]){
            $conn = $this->SqlConn();
            $sql = "SELECT * FROM user WHERE username = '" . decrypt($_COOKIE["admin"]) . "'"."AND type = 0";
            $result = $conn->query($sql);
            if($result->num_rows > 0){

                return true;
            }
        }
        return false;

    }

    public function CommManage(){
        $conn = $this->SqlConn();
        $a = array();
        $sql1 = "SELECT * FROM `message` WHERE CheckMess=1";
        $sql2 = "SELECT * FROM `message` WHERE CheckMess=0 AND HitBack=0";
        $sql3 = "SELECT * FROM `message`WHERE CheckMess = 1 OR HitBack = 1";
        $result1 = $conn->query($sql1);
        $result2 = $conn->query($sql2);
        $result3 = $conn->query($sql3);
        $a[0] = mysqli_fetch_all($result1);
        $a[1] = mysqli_fetch_all($result2);
        $a[2] = mysqli_fetch_all($result3);
        return $a;
    }

    public function CommSh(){
        $conn = $this->SqlConn();
        if($_GET['ac']=='pass'){
            $sql = "UPDATE `message` SET `CheckMess`=1 , HitBack=0 WHERE id = ".$_GET['id'].";";
        }
        elseif ($_GET['ac']=='back'){
            $sql = "UPDATE `message` SET `CheckMess`=0 , HitBack=1 WHERE id = ".$_GET['id'].";";
        }
        $result = $conn->query($sql);
        return $result;
    }

    public function CommManage_1($arr){
        $conn = $this->SqlConn();
        $result_1 = array();
        foreach($arr as $num => $value){
            $sql = "SELECT name FROM gedan where id = " . $value[4];
            $result_1[$num] = mysqli_fetch_all($conn -> query($sql))[0][0];
        }
        return $result_1;
    }

    public function CommDel(){
        $conn = $this->SqlConn();
        $sql = "DELETE FROM `message` WHERE id = " . $_GET["id"];
        return $conn -> query($sql);
    }

    public function GedanManage(){
        $conn = $this->SqlConn();
        $result = array();
        $sql1 = "SELECT * FROM gedan ;";
        $sql2 = "SELECT `id`,`name` FROM music WHERE `CheckMusic` = 1;";
        $res1 = mysqli_fetch_all($conn->query($sql1));
        $res2 = mysqli_fetch_all($conn->query($sql2));
        $res3 = array();
        foreach ($res1 as $key => $value) {
            $sql3 = "SELECT `name` FROM music WHERE FIND_IN_SET('".$value[0]."',gedan)";
            $res3[$value[0]] = mysqli_fetch_all($conn->query($sql3));
        }
        $result[0] = $res1;             //歌单信息
        $result[1] = $res2;             //所有歌曲
        $result[2] = $res3;             //各个歌单的歌曲
        return $result;
    }

    public function GedanManageAc(){
        $conn = $this->SqlConn();
        if($_POST['name']){
            $sql = "UPDATE gedan SET `up_time`='".date('Y-m-d')."',`name` = '".$_POST['name']."' where `id` = ".$_GET['id'].";";
            $conn->query($sql);
        }
        if($_POST['intro']){
            $sql = "UPDATE gedan SET `up_time`='".date('Y-m-d')."', `intro` = '".$_POST['intro']."' where `id` = ".$_GET['id'].";";
            $conn->query($sql);
        }
        if($_POST['hits']){
            $sql = "UPDATE gedan SET `up_time`='".date('Y-m-d')."', `hits` = ".$_POST['hits']." where `id` = ".$_GET['id'].";";
            $conn->query($sql);
        }
        if($_POST['songs']){
            $sql = "update `music` set gedan=replace(gedan,'".$_GET['id'].",','')";
            $conn->query($sql);
            foreach ($_POST['songs'] as $key => $value) {
                $sql = "UPDATE music SET `gedan` = CONCAT(gedan,'".$_GET['id'].",') where id = ".$value.";";
                $conn->query($sql);
            }
        }

    }
    public function GedanManageAdd($imagepath){
        $conn = $this->SqlConn();
        $user = "admin";
        if($conn -> query("select * from gedan where name = '".$_POST["gedanname"]."'")->num_rows > 0){

            return false;
        }
        $sql1 = "INSERT INTO `gedan` (`id`,`name`,`author`,`imgpath`,`intro`,`type`,`hits`,`up_time`)
                VALUES(NULL,'".$_POST["gedanname"]."','".$user."','".$imagepath."','".$_POST["intro"]."',1,0,'".date('Y-m-d')."');";
        //INSERT INTO `gedan` (`id`,`name`,`author`,`imgpath`,`intro`,`type`,`hits`)
        //VALUES(NULL,$_POST["gedanname"],$user,$imagepath,$_POST["intro"],0,0)
        $conn->query($sql1);
        $res = mysqli_fetch_all($conn->query("SELECT id FROM gedan where name = '".$_POST["gedanname"]."';"))[0][0];

        if($res){
            foreach ($_POST['songs'] as $key => $value) {
                $sql2 = "UPDATE music SET `gedan` = CONCAT(gedan,'".$res.",') where id = ".$value.";";
                $conn->query($sql2);
            }
            return true;
        }
        return false;
    }


    public function GedanDel(){
        $conn = $this->SqlConn();
        $sql = "DELETE FROM `gedan` WHERE id = " . $_GET["id"];
        return $conn->query($sql);
    }

    public function SongAudit(){
        $conn = $this->SqlConn();
        $a = array();
        $sql = "SELECT * FROM `music` WHERE CheckMusic = 0 AND HitBack != 1;";
        $sql1 = "SELECT * FROM `music`WHERE CheckMusic = 1 OR HitBack = 1;";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql1);
        $a[0] = mysqli_fetch_all($result);
        $a[1] = mysqli_fetch_all($result1);
        return $a;
    }

    public function SongAction(){
        $conn = $this->SqlConn();
        if($_GET['ac']==="pass"){
            $sql = "update `music` set `CheckMusic` = 1 , `HitBack` = 0 where `id` = ".$_GET['id'].";";
        }
        elseif ($_GET['ac']==="back"){
            $sql = "update `music` set `CheckMusic` = 0 , `HitBack` = 1 ,`reason`= '".$_GET['reason']."' where `id` = ".$_GET['id'].";";
        }

        $conn->query($sql);

    }

    public function SongManage(){
        $conn = $this->SqlConn();
        $sql = "SELECT * FROM `music` WHERE CheckMusic = 1 AND HitBack = 0;";
        return mysqli_fetch_all($conn->query($sql));

    }

    public function SongDel(){
        $conn = $this->SqlConn();
        $sql = "DELETE FROM `music` WHERE `id` = ". $_GET['id'].";";
        return $conn -> query($sql);
    }

    public function SongAdd($audiopath){
        $conn = $this->SqlConn();

        $rgb = $_POST['rgb'] ? $_POST['rgb'] : 0;
        $ndb = $_POST['ndb'] ? $_POST['ndb'] : 0;
        $rhb = $_POST['rhb'] ? $_POST['rhb'] : 0;

        $sql = "INSERT INTO `music` (`id`, `name`, `author`, `imgpath`, `time`, `lyric`, `audiopath`, `gedan`, `hits`, `rgb`,`ndb`,`rhb`,`CheckMusic`,`HitBack`,`up_time`,`reason`)
                VALUES (NULL,'".$_POST['songname']."','".$_POST['author']."','"."../static/images/music.png"."','3.00','".str_replace("\n","<br>",$_POST['lyric'])."','".$audiopath."','',0,".$rgb.",".$ndb.",".$rhb.",1,0,'".date('Y-m-d')."',0);";
        //VALUES (NULL,'$_POST['songname']','$_POST['author']','../static/images/music.png','3.00','str_replace("\t\n","<br>",$_POST['lyric'])','$audiopath',NULL,0,$_POST['rgb'],$_POST['ndb'],$_POST['rhb'],1,0);

        return $conn -> query($sql);
    }


    public function UserManage(){
            $conn = $this->SqlConn();
            $sql = "SELECT * FROM user where type != 0";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $res = mysqli_fetch_all($result);
                return $res;
            }
    }

    public function UserAdd($txpath){
        $conn = $this->SqlConn();
        $sql = "select * from user where username = '" . $_POST['username'] . "'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            return false;
        }
        $sql = "INSERT INTO `user` (`id`, `username`, `password`, `txpath`, `nickname`, `phone`, `gxqm`, `zcsj`, `mail`, `type`)
                VALUES (NULL ,'".$_POST['username']."', '".hash('md4',$_POST['password'])."', '".$txpath."', '','".$_POST['phone']."','','".time()."','".$_POST['email']."',".$_POST['status'].");";
        return $conn -> query($sql);
    }

    public function UserDelete($name){
        $conn = $this->SqlConn();
        $sql = "DELETE FROM user WHERE username = '" . $name . "'";
        return $conn->query($sql);



    }
    public function UserEdit($txpath){
        $conn = $this->SqlConn();
        if($_FILES["tx"]["name"]&&$_POST['password']){
            $sql = "UPDATE `user`
                    SET `password` = '".hash('md4',$_POST['password'])."', `txpath` = '".$txpath."',`phone` = '".$_POST['phone']."',`mail` = '".$_POST['email']."',`type` = ".$_POST['status']."
                     WHERE `username`='".$_POST['username']."';";
        }
        elseif ($_FILES["tx"]["name"]){
            $sql = "UPDATE `user`
                    SET `txpath` = '".$txpath."',`phone` = '".$_POST['phone']."',`mail` = '".$_POST['email']."',`type` = ".$_POST['status']."
                     WHERE `username`='".$_POST['username']."';";
        }
        elseif ($_POST['password']){
            $sql = "UPDATE `user`
                    SET `password` = '".hash('md4',$_POST['password'])."',`phone` = '".$_POST['phone']."',`mail` = '".$_POST['email']."',`type` = ".$_POST['status']."
                     WHERE `username`='".$_POST['username']."';";
        }
        else{
            $sql = "UPDATE `user`
                    SET `phone` = '".$_POST['phone']."',`mail` = '".$_POST['email']."',`type` = ".$_POST['status']."
                     WHERE `username`='".$_POST['username']."';";
        }

        return $conn->query($sql);
    }

    public function logoff(){
        setcookie("admin", "", time() - 3600);
    }

    private function SqlConn(){
        return new mysqli("localhost", "root", "root", "music");
    }



}
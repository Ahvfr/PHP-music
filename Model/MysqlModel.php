<?php

require_once('PublicModel.php');

class mysql{

    // Mysql连接
    public function connect() {
        $servername = "localhost";
        $username = 'root';
        $password = 'root';
        $dbname = 'music';

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        return $conn;
    }

    // 随机获取每日推荐的四首歌曲
    public function getDaily() {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT * FROM music WHERE CheckMusic = 1 ORDER BY RAND() LIMIT 0,4";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        $conn->close();
        return $res;
    }

    // 随机获取推荐歌单
    public function getGedan() {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT * FROM gedan  ORDER BY RAND() LIMIT 0,3";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        $conn->close();
        return $res;
    }

    // 获取4条官方歌单（按照播放量排序）
    public function getGfGedan($a) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $a = 4 * ($a-1);
        $sql = "SELECT * FROM gedan WHERE type=1 ORDER BY hits DESC LIMIT ".$a.",4";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        $conn->close();
        return $res;
    }

    // 获取8条用户歌单（按照播放量排序）
    public function getYhGedan($a) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $a = 8 * ($a-1);
        $sql = "SELECT * FROM gedan WHERE type=0 ORDER BY hits DESC LIMIT ".$a.",8";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        $conn->close();
        return $res; 
    }

    // 获取榜单
    public function getBangdan() {
        $bangdan = array('rgb','ndb','rhb');
        $data = array();
        $mysql = new mysql();
        $conn = $mysql->connect();
        for ($i = 0 ; $i < count($bangdan) ; $i++){
            $sql = "SELECT * FROM music WHERE " .$bangdan[$i]."=1 AND CheckMusic = 1 ORDER BY hits DESC LIMIT 0,20";
            $res = $conn->query($sql);
            $data[$bangdan[$i]] = mysqli_fetch_all($res);
        }
        $conn->close();
        //var_dump($data);
        //die();
        return $data;
    }

    // 判断页码
    public function jugGpage() {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT count(*) FROM gedan WHERE type=1";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        $conn->close();
        return $res[0][0];
    }

    public function jugYpage() {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT count(*) FROM gedan WHERE type=0";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        $conn->close();
        return $res[0][0];
    }

    // 登录
    public function doLogin($user,$password) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT password FROM user WHERE type = ".$_POST['type']." AND username = '".$user."'";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        if ($res) {
            return hash('md4',$password) == $res[0][0] ? true : false;
        } else {
            return false;
        }
    }

    // 注册
    public function doRegister($user,$password) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql1 = "SELECT * FROM user WHERE username = '".$user."'";
        $sql2 = "INSERT INTO user (username,password,txpath,zcsj,type) VALUES ('".$user."','".hash('md4',$password)."','../static/images/user.png',".time().",".$_POST['type'].")";
        $res1 = $conn->query($sql1);
        $res1 = mysqli_fetch_all($res1);
        if (!$res1) {
            $res2 = $conn->query($sql2);
            if ($res2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getTxpath($user) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT txpath FROM user WHERE username = '".$user."'";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        return $res[0][0];
    }

    // 获取用户信息
    public function getUserInfo($user) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT * FROM user WHERE username = '".$user."'";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        return $res[0];
    }

    public function getUserInfoById($id) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT * FROM user WHERE id = '".$id."'";
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        return $res[0];
    }

    // 修改用户信息
    public function changeUserInfo($name,$user) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        if(!($user->txpath))
        {
            $res_1 = $mysql->getUserInfo($name);
            $user->txpath = $res_1[3];

        }
        $sql = "UPDATE user SET nickname='".$user->nickname."',phone='".$user->phone."',txpath='".$user->txpath."',gxqm='".$user->gxqm."' WHERE username='".$name."'";
        $res = $conn->query($sql);
        return $res;
    }

    // 查询音乐路径
    public function GetMusicPath($id) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "SELECT * FROM music WHERE id=".$id;
        $res = $conn->query($sql);
        $res = mysqli_fetch_all($res);
        //var_dump($res[0]);
        return $res[0];
    }

    //增加浏览量
    public function AddMusicHit($id,$hits)
    {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $hits+=1;
        $sql = "update music set hits='".$hits."' where id=".$id;
        $res = $conn->query($sql);
        return 0;
    }

    // 获取歌单详细信息
    public function GetGedanDetail($id) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql1 = "SELECT * FROM gedan WHERE id=".$id;
        $sql2 = "SELECT * FROM music WHERE FIND_IN_SET('".$id."',gedan)";
        $sql3 = "SELECT * FROM message WHERE CheckMess= 1 AND gedan=".$id." limit 0,4";
        $res = array();
        $res1 = $conn->query($sql1);
        $res2 = $conn->query($sql2);
        $res3 = $conn->query($sql3);
        $res1 = mysqli_fetch_all($res1)[0];
        $res2 = mysqli_fetch_all($res2);
        $res3 = mysqli_fetch_all($res3);
        $res['gedan'] = $res1;
        $res['music'] = $res2;
        $res['message'] = $res3;
        return $res;
    }

    //增加Hits
    public function AddGedanHit($id,$hits)
    {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $hits+=1;
        $sql = "update gedan set hits='".$hits."' where id=".$id;
        $res = $conn->query($sql);
        return 0;
    }

    // 增加留言
    public function AddMessage($content,$gedan,$cookie) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        if(!empty($cookie))
        {
            $user = decrypt($cookie);
            $sql = "INSERT INTO message (username,content,time,gedan,CheckMess,HitBack) VALUES ('".$user."'".",'".$content."','".time()."',".$gedan.",0,0)";
        }

        $res = $conn->query($sql);
        return $res;
    }

    public function AddMessage_re($content,$id,$cookie,$gedan) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $user = decrypt($cookie);
        $sql = "select id from gedan where name ='".$gedan."';";
        $result = mysqli_fetch_all($conn->query($sql))[0][0];
        $sql = "UPDATE message set CheckMess=0,HitBack=0,time='".time()."',content='".$content."' where id=".$id." and gedan=".$result." and username='".$user."';";
        $res = $conn->query($sql);
        return $res;
    }

    public function CommDel($user){
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "DELETE FROM message WHERE username='".$user."' and id = ".$_GET['id'].";";
        $conn->query($sql);
    }

    public function CommManage($user){
        $mysql = new mysql();
        $conn = $mysql->connect();
        $res = array();
        $sql1 = "SELECT * FROM message where CheckMess=1 and username='".$user."'";
        $sql2 = "SELECT * FROM message where HitBack=1 and username='".$user."'";
        $sql3 = "SELECT * FROM message where CheckMess=0 and HitBack=0 and username='".$user."'";
        $res1 = $conn->query($sql1);
        $res2 = $conn->query($sql2);
        $res3 = $conn->query($sql3);
        $res[0] = mysqli_fetch_all($res1);
        $res[1] = mysqli_fetch_all($res2);
        $res[2] = mysqli_fetch_all($res3);
        return $res;
    }
    public function CommManage_1($arr){
        $mysql = new mysql();
        $conn = $mysql->connect();
        $result_1 = array();
        foreach($arr as $num => $value){
            $sql = "SELECT name FROM gedan where id = " . $value[4];
            $result_1[$num] = mysqli_fetch_all($conn -> query($sql))[0][0];
        }
        return $result_1;
    }

    public function getMusicUserInfo($user) {
        $mysql = new mysql();
        $conn = $mysql->connect();
        $res = array();
        $sql1 = "SELECT * FROM music WHERE `CheckMusic` =0 AND  `HitBack` = 0 AND `uid` = ".$user->id;
        $sql2 = "SELECT * FROM music WHERE `CheckMusic` =1 AND  `HitBack` = 0 AND `uid` = ".$user->id;
        $sql3 = "SELECT * FROM music WHERE `CheckMusic` =0 AND  `HitBack` = 1 AND `uid` = ".$user->id;
        $res1 = $conn->query($sql1);
        $res2 = $conn->query($sql2);
        $res3 = $conn->query($sql3);
        $res[0] = mysqli_fetch_all($res1);
        $res[1] = mysqli_fetch_all($res2);
        $res[2] = mysqli_fetch_all($res3);
        return $res;
    }

    public function ReUp(){
        $mysql = new mysql();
        $conn = $mysql->connect();

        $rgb = $_POST['rgb'] ? $_POST['rgb'] : 0;
        $ndb = $_POST['ndb'] ? $_POST['ndb'] : 0;
        $rhb = $_POST['rhb'] ? $_POST['rhb'] : 0;

        if($_FILES["audio"]["name"]){
            $allowedExts = array("mp3");
            $temp = explode(".", $_FILES["audio"]["name"]);
            $extension = end($temp);
            if (!in_array($extension, $allowedExts)) {
                die("<script>alert('音频类型错误');window.location.replace('./?a=Upload&type=1');</script>");
            }
            move_uploaded_file($_FILES["audio"]["tmp_name"], "./static/music/" . $_POST["name"] . "." . $extension);
            $audiopath = "../static/music/" . $_POST["name"] . "." . $extension;
            $sql = "UPDATE `music` set `name`='".$_POST['name']."',`author`='".$_POST['author']."',`lyric`='".$_POST['lyric']."',`audiopath`='".$audiopath."',`rgb`=".$rgb.",`ndb`=".$ndb.",`rhb`=".$rhb.",`CheckMusic`=0,`HitBack`=0,`up_time`='".date('Y-m-d')."',`reason`=0 where id=".$_GET['id'].";";
        }else{
            $sql = "UPDATE `music` set `name`='".$_POST['name']."',`author`='".$_POST['author']."',`lyric`='".$_POST['lyric']."',`rgb`=".$rgb.",`ndb`=".$ndb.",`rhb`=".$rhb.",`CheckMusic`=0,`HitBack`=0,`up_time`='".date('Y-m-d')."',`reason`=0 where id=".$_GET['id'].";";
        }
        $conn->query($sql);
    }
    public function UploadChuli($audiopath,$uid){
        $mysql = new mysql();
        $conn = $mysql->connect();

        $rgb = $_POST['rgb'] ? $_POST['rgb'] : 0;
        $ndb = $_POST['ndb'] ? $_POST['ndb'] : 0;
        $rhb = $_POST['rhb'] ? $_POST['rhb'] : 0;

        $sql_1 = "select * from music where name = '".$_POST['songname']."'";
        $res_1 = $conn->query($sql_1);
        if($res_1->num_rows > 0){
            $conn->query("DELETE FROM music WHERE name = '".$_POST['songname']."'");
        }

        $sql = "INSERT INTO `music` (`id`, `name`, `author`, `imgpath`, `time`, `lyric`, `audiopath`, `gedan`, `hits`, `rgb`,`ndb`,`rhb`,`CheckMusic`,`HitBack`,`uid`,`up_time`,`reason`)
                VALUES (NULL,'".$_POST['songname']."','".$_POST['author']."','"."../static/images/music.png"."','3.00','".str_replace("\n","<br>",$_POST['lyric'])."','".$audiopath."','',0,".$rgb.",".$ndb.",".$rhb.",0,0,".$uid.",'".date('Y-m-d')."',0);";
        $res = $conn->query($sql);
        return $res;
    }

    public function AddGedan(){
        $mysql = new mysql();
        $conn = $mysql->connect();

        $sql = "SELECT `id`,`name` FROM music WHERE `CheckMusic` =1";
        return mysqli_fetch_all($conn->query($sql));
    }

    public function AddGedanAction($imagepath,$user){
        $mysql = new mysql();
        $conn = $mysql->connect();
        if($conn -> query("select * from gedan where name = '".$_POST["gedanname"]."'")->num_rows > 0){

            return false;
        }
        $sql1 = "INSERT INTO `gedan` (`id`,`name`,`author`,`imgpath`,`intro`,`type`,`hits`,`up_time`)
                VALUES(NULL,'".$_POST["gedanname"]."','".$user."','".$imagepath."','".$_POST["intro"]."',0,0,'".date('Y-m-d')."');";
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

    public function GedanManage($user){
        $mysql = new mysql();
        $conn = $mysql->connect();
        $result = array();
        $sql1 = "SELECT `id`,`name`,`intro`,`hits`,`up_time` FROM gedan WHERE `author` = '".$user."';";
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
    public function GedanManage_ac($user){
        $mysql = new mysql();
        $conn = $mysql->connect();
        if($_POST['name']){
            $sql = "UPDATE gedan SET `up_time`='".date('Y-m-d')."', `name` = '".$_POST['name']."' where author = '".$user."' AND `id` = ".$_GET['id'].";";
            $conn->query($sql);
        }
        if($_POST['author']){
            $sql = "UPDATE gedan SET `up_time`='".date('Y-m-d')."', `intro` = '".$_POST['author']."' where author = '".$user."' AND `id` = ".$_GET['id'].";";
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
    public function GedanManage_del($user){
        $mysql = new mysql();
        $conn = $mysql->connect();
        $sql = "DELETE FROM `gedan` WHERE `author` = '".$user."' AND `id` =".$_GET['id'].";";
        $conn->query($sql);
    }

}

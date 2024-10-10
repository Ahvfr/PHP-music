<?php
class AdminController {

    public function Index() {
        $object = $this -> Check();
        $result = $object->Index();
        require_once('./View/Index.html');

    }

    public function Login() {
        if($_COOKIE['admin']){
            //echo "window.location.replace('./?a=Index');</script>";
            header('Location: ./?a=Index');
        }

        if(!$_POST['username'] || !$_POST['password']) {
            require_once('./View/Login.html');

        }
        else{
            $username = $_POST['username'];
            $password = $_POST['password'];
            require_once('./Model/LoginModel.php');
            $object = new LoginModel();
            $result = $object->Login($username, $password);
            if($result) {
                setcookie('admin' , encrypt($username), time() + 3600);
                echo "<script>alert('登陆成功');window.location.replace('./?a=Index');</script>";
            }
            else {
                echo "<script>alert('账号或密码错误');window.location.replace('./?a=Login');</script>";
            }
        }


    }

    public function UserManage() {
        $object = $this -> Check();
        $result = $object->UserManage();
        require_once('./View/UserManage.html');

    }


    public function UserEdit() {
        $object = $this -> Check();
        if($_FILES["tx"]["name"]){
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["tx"]["name"]);
            $extension = end($temp);
            if(!in_array($extension, $allowedExts)){
                die("<script>alert('图片类型错误');window.location.replace('./?a=UserManage');</script>");
            }
            move_uploaded_file($_FILES["tx"]["tmp_name"],"../static/images/" . $_POST["username"] . "." . $extension);

            $txpath = "../static/images/" . $_POST["username"] . "." . $extension;
        }
        $result = $object->UserEdit($txpath);
        if(!$result) {
            die("<script>alert('修改失败');window.location.replace('./?a=UserManage');</script>");
        }
        echo "<script>alert('修改成功');window.location.replace('./?a=UserManage');</script>";
    }


    public function UserDelete(){

        $object = $this -> Check();
        $name = $_GET['which'];
        $result = $object->UserDelete($name);
        if(!$result) {
            die("<script>alert('删除失败');window.location.replace('./?a=UserManage');</script>");
        }
        echo "<script>alert('删除成功');window.location.replace('./?a=UserManage');</script>";


    }

    public function UserAdd(){
        $object = $this -> Check();
        if($_FILES["tx"]["name"]){
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["tx"]["name"]);
            $extension = end($temp);
            if(!in_array($extension, $allowedExts)){
                die("<script>alert('图片类型错误');window.location.replace('./?a=UserManage');</script>");
            }
            move_uploaded_file($_FILES["tx"]["tmp_name"],"../static/images/" . $_POST["username"] . "." . $extension);

            $txpath = "../static/images/" . $_POST["username"] . "." . $extension;
        }
        $result = $object->UserAdd($txpath);
        if(!$result) {
            die("<script>alert('添加失败或用户已存在');window.location.replace('./?a=UserManage');</script>");
        }
        echo "<script>alert('添加成功');window.location.replace('./?a=UserManage');</script>";
    }

    public function SongAudit(){
        $object = $this -> Check();
        $a = $object->SongAudit();
        $result = $a[0];
        $result1 = $a[1];
        require_once('./View/SongAudit.html');
    }

    public function SongAction(){
        $object = $this -> Check();
        $object->SongAction();
        echo "<script>window.location.replace('./?a=SongAudit');</script>";
    }

    public function SongManage(){
        $object = $this -> Check();
        $result = $object->SongManage();
        require_once('./View/SongManage.html');
    }


    public function SongDel(){
        $object = $this -> Check();
        $result = $object->SongDel();
        if(!$result) {
            die("<script>alert('删除失败');window.location.replace('./?a=SongManage');</script>");
        }
        echo "<script>alert('删除成功');window.location.replace('./?a=SongManage');</script>";
    }


    public function SongAdd(){
        $object = $this -> Check();
        $allowedExts = array("mp3");
        $temp = explode(".", $_FILES["audio"]["name"]);
        $extension = end($temp);
        if(!in_array($extension, $allowedExts)){
            die("<script>alert('音频类型错误');window.location.replace('./?a=SongManage');</script>");
        }
        move_uploaded_file($_FILES["audio"]["tmp_name"],"../static/music/" . $_POST["songname"] . "." . $extension);

        $audiopath = "../static/music/" . $_POST["songname"] . "." . $extension;
        $result = $object->SongAdd($audiopath);
        if(!$result) {
            die("<script>alert('添加失败');window.location.replace('./?a=SongManage');</script>");
        }
        echo "<script>alert('添加成功');window.location.replace('./?a=SongManage');</script>";
    }


    public function GedanManage(){
        $object = $this -> Check();
        $result = $object->GedanManage();
        require_once('./View/GedanManage.html');
    }

    public function GedanManageAc(){
        $object = $this -> Check();
        $result = $object->GedanManageAc();
        echo "<script>window.location.replace('./?a=GedanManage');</script>";
    }
    public function GedanManageAdd(){
        $object = $this -> Check();
        $imagepath = "../static/images/官方歌单_2.png";
        if($_FILES["upload_image"]["name"]){
            $allowedExts = array("jpg", "jpeg", "gif", "png");
            $temp = explode(".", $_FILES["upload_image"]["name"]);
            $extension = end($temp);
            if (!in_array($extension, $allowedExts)) {
                die("<script>alert('图片类型错误');window.location.replace('./?a=GedanManage');</script>");
            }
            move_uploaded_file($_FILES["upload_image"]["tmp_name"], "../static/images/" . $_POST["gedanname"] . "." . $extension);
            $imagepath = "../static/images/" . $_POST["gedanname"] . "." . $extension;
        }
        $result = $object->GedanManageAdd($imagepath);
        if(!$result) {
            die("<script>alert('添加失败');window.location.replace('./?a=GedanManage');</script>");
        }
        echo "<script>alert('添加成功');window.location.replace('./?a=GedanManage');</script>";
    }

    public function GedanDel(){
        $object = $this -> Check();
        $result = $object->GedanDel();
        if(!$result) {
            die("<script>alert('删除失败');window.location.replace('./?a=GedanManage');</script>");
        }
        die("<script>alert('删除成功');window.location.replace('./?a=GedanManage');</script>");
    }

    public function CommManage(){
        $object = $this -> Check();
        $a = $object->CommManage();
        $result = $a[0];
        $result1 = $a[1];
        $result2 = $a[2];
        //var_dump($result2);
        //die();
        $result_1 = $object->CommManage_1($result);
        $result_2 = $object->CommManage_1($result1);
        $result_3 = $object->CommManage_1($result2);
        require_once('./View/CommManage.html');
    }

    public function CommSh(){
        $object = $this -> Check();
        $result = $object->CommSh();
        echo "<script>window.location.replace('./?a=CommManage');</script>";
    }

    public function CommDel(){
        $object = $this -> Check();
        $result = $object->CommDel();
        if(!$result) {
            die("<script>alert('删除失败');window.location.replace('./?a=CommManage');</script>");
        }
        die("<script>alert('删除成功');window.location.replace('./?a=CommManage');</script>");
    }

    public function logoff(){
        $object = $this -> Check();
        $object->logoff();
        die( "<script>window.location.replace('http://music/');</script>");
    }

    private function Check()
    {
        if($_COOKIE['admin']){
            require_once('./Model/IndexModel.php');
            $object = new IndexModel();
            $check = $object->CheckLogin();
            if(!$check){
                setcookie('admin' , "", time() - 3600);
                die( "<script>window.location.replace('./?a=Login');</script>");
            }
        }
        else{
            die( "<script>window.location.replace('./?a=Login');</script>");
        }
        return $object;
    }

}
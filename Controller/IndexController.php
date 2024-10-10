<?php    

class IndexController {
    public function Index() {
        require_once('./Model/IndexModel.php');
        $object = new IndexModel();
        $daily = $object->getDaily();
        $gedan = $object->getGedan();
        require_once('./View/Index.html');
    }

    public function Gedan() {
        require_once('./Model/GedanModel.php');
        $object = new GedanModel();
        $gpage = isset($_GET['gpage']) ? intval($_GET['gpage']) : 1;
        $ypage = isset($_GET['ypage']) ? intval($_GET['ypage']) : 1;
        $gpage = $gpage > 0 ? $gpage : 1;
        $gpage = $gpage < $object->jugGpage() ? $gpage : $object->jugGpage();
        $ypage = $ypage > 0 ? $ypage : 1;
        $ypage = $ypage < $object->jugYpage() ? $ypage : $object->jugYpage();
        $GFgedan = $object->getGfGedan($gpage);
        $YHgedan = $object->getYhGedan($ypage);
        require_once('./View/Gedan.html');
    }

    public function Bangdan() {
        require_once('./Model/BangdanModel.php');
        $object = new BangdanModel();
        $bangdan = $object->getBangdan();
        $type = $_GET['type'] ? $_GET['type'] : 1;
        require_once('./View/Bangdan.html');
    }

    public function Login() {
        require_once('./Model/LoginModel.php');
        if (isset($_POST['user']) && $_POST['user'] != null) {
            $user = addslashes(str_replace(' ','',$_POST['user']));
        }else{
            die("<script>alert('账号不能为空');window.location.replace('./index.php');</script>");
        }
        if (isset($_POST['password']) && $_POST['password'] != null) {
            $password = addslashes(str_replace(' ','',$_POST['password']));
        }else{
            die("<script>alert('密码不能为空');window.location.replace('./index.php');</script>");
        }
        $object = new LoginModel();
        if(isset($_POST['login'])) {
            $res = $object->doLogin($user, $password);
            if ($res) {
                setcookie('user' , encrypt($user), time() + 3600);
                echo "<script>alert('登陆成功');window.location.replace('./index.php');</script>";
            } else {
                echo "<script>alert('账号或密码错误');window.location.replace('./index.php');</script>";
            }
        }else if(isset($_POST['register'])) {
            $res = $object->doRegister($user, $password);
            if ($res) {
                setcookie('user' , encrypt($user), time() + 3600);
                echo "<script>alert('注册成功，即将自动登录');window.location.replace('./index.php');</script>";
            } else {
                echo "<script>alert('注册失败');window.location.replace('./index.php');</script>";
            }
        }
    }

    // 个人信息界面
    public function Profile() {
        require_once('./Model/ProfileModel.php');
        if (isset($_COOKIE['user'])) {
            $object = new ProfileModel();
            $userInfo = $object->getUserInfo(decrypt($_COOKIE['user']));
            require_once('./View/Profile.html');
        } else {
            die("<script>alert('您还没有登录，请登录！');window.location.replace('./index.php');</script>");
        }
    }

    // 收藏界面


    // 个人信息修改
    public function ChangeInfo() {
        require_once('./Model/ChangeInfoModel.php');
        $object = new ChangeInfoModel();
        $user = new user();



        $user->nickname = htmlspecialchars(addslashes($_POST['nickname']),ENT_QUOTES);
        $user->phone = htmlspecialchars(addslashes($_POST['phone']),ENT_QUOTES);
        $user->email = htmlspecialchars(addslashes($_POST['email']),ENT_QUOTES);
        $user->gxqm = htmlspecialchars(addslashes($_POST['gxqm']),ENT_QUOTES);

        $res = $object->ChangeUserInfo(decrypt($_COOKIE['user']),$user);
        if ($res) {
            echo "<script>alert('信息修改成功');window.location.replace('./index.php?a=Profile');</script>";
        } else {
            echo "<script>alert('信息修改出错');window.location.replace('./index.php?a=Profile');</script>";
        }
    }

    // 音乐播放界面
    public function PlayMusic() {
        require_once('./Model/PlayMusicModel.php');
        $object = new PlayMusicModel();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $id = $id < 1 ? 1 : $id;
        $MusicPath = $object->GetMusicPath($id);
        require_once('./View/PlayMusic.html');
    }

    // 歌单详情页面
    public function GedanDetail() {
        require_once('./Model/GedanDetailModel.php');
        $object = new GedanDetailModel();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $GedanDetail = $object->GetGedanDetail($id);
        // var_dump($GedanDetail);
        require_once('./View/GedanDetail.html');
    }

    // 增加留言
    public function AddMessage() {
        require_once('./Model/AddMessageModel.php');
        $object = new AddMessageModel();
        if(!($object->CheckUser(decrypt($_COOKIE['user'])))) {
            die("<script>alert('请先登入！');window.location.replace('./index.php?a=GedanDetail&id=".$_GET['id']."');</script>");
        }
        if (isset($_POST['message']) && isset($_GET['id'])) {
            if($_GET['type'] === 're'){

                $object->AddMessage_re(htmlspecialchars($_POST['message'],ENT_QUOTES),$_GET['id'],$_COOKIE['user'],$_GET['gedan']);
                echo "<script>window.location.replace('./index.php?a=CommManage');</script>";
            }
            else{
                $res = $object->AddMessage(htmlspecialchars($_POST['message'],ENT_QUOTES),$_GET['id'],$_COOKIE['user']);
                if ($res) {
                    echo "<script>alert('成功留言！');window.location.replace('./index.php?a=GedanDetail&id=".$_GET['id']."');</script>";
                } else {
                    echo "<script>alert('留言失败！');window.location.replace('./index.php?a=GedanDetail&id=".$_GET['id']."');</script>";
                }
            }

        } else {
            die("<script>alert('请校验参数！');window.location.replace('./index.php');</script>");
        }
    }

    public function CommManage(){
        require_once('./Model/CommManage.php');
        if(!$_COOKIE['user']){
            die("<script>alert('请先登入！');window.location.replace('./index.php');</script>");
        }
        $object = new CommManageMod();
        $result = $object->CommManage(decrypt($_COOKIE['user']));
        $result1 = $object->CommManage_1($result[0]);
        $result2 = $object->CommManage_1($result[1]);
        $result3 = $object->CommManage_1($result[2]);
        require_once('./View/CommManage.html');
    }

    public function CommDel(){
        require_once('./Model/CommDelModel.php');
        if(!$_COOKIE['user']){
            die("<script>alert('请先登入！');window.location.replace('./index.php');</script>");
        }
        $object = new CommDelModel();
        $object->CommDel(decrypt($_COOKIE['user']));
        echo "<script>window.location.replace('./index.php?a=CommManage');</script>";
    }

    public function Upload() {
        require_once('./Model/UploadModel.php');
        if (isset($_COOKIE['user'])) {
            $object = new UploadModel();
            $userInfo = $object->getUserInfo(decrypt($_COOKIE['user']));
            if($userInfo->type != 1){
                die("<script>window.location.replace('./index.php');</script>");
            }
            $musicuserInfo = $object->GetMusicUserInfo($userInfo);
            require_once('./View/Upload.html');
        } else {
            die("<script>alert('您还没有登录，请登录！');window.location.replace('./index.php');</script>");
        }
    }
    public function ReUp() {
        require_once('./Model/ReUpModel.php');
        $object = new ReUpModel();
        $object->ReUp();
        die("<script>window.location.replace('./?a=Upload');</script>");
    }

    public function UploadChuli(){
        require_once('./Model/UploadChuliModel.php');
        require_once('./Model/UploadModel.php');
        if (isset($_COOKIE['user'])) {
            $object = new UploadModel();
            $userInfo = $object->getUserInfo(decrypt($_COOKIE['user']));
            if ($userInfo->type != 1) {
                die("<script>window.location.replace('./index.php');</script>");
            }

            $allowedExts = array("mp3");
            $temp = explode(".", $_FILES["audio"]["name"]);
            $extension = end($temp);
            if (!in_array($extension, $allowedExts)) {
                die("<script>alert('音频类型错误');window.location.replace('./?a=Upload&type=1');</script>");
            }
            move_uploaded_file($_FILES["audio"]["tmp_name"], "./static/music/" . $_POST["songname"] . "." . $extension);
            $audiopath = "../static/music/" . $_POST["songname"] . "." . $extension;

            $object = new UploadChuliModel();
            $res = $object->UploadChuli($audiopath, $userInfo->id);
            if (!$res) {
                die("<script>alert('添加失败');window.location.replace('./?a=Upload&type=1');</script>");
            }
            echo "<script>alert('添加成功');window.location.replace('./?a=Upload');</script>";
        }
    }
    public function AddGedan(){
        require_once('./Model/AddGedanModel.php');
        require_once('./Model/ProfileModel.php');
        if (isset($_COOKIE['user'])) {
            if((new ProfileModel())->getUserInfo(decrypt($_COOKIE['user']))){
                if($_GET['action'] === '1'){
                    if(!((new AddGedanModel) -> AddGedanAction(decrypt($_COOKIE['user'])))){
                        die("<script>alert('添加失败');window.location.replace('./?a=AddGedan');</script>");
                    }
                    echo("<script>alert('添加成功');window.location.replace('./?a=Profile');</script>");
                }
                $result = (new AddGedanModel) -> AddGedan();
                require_once('./View/AddGedan.html');
            }else{
                die("<script>alert('您还没有登录，请登录！');window.location.replace('./index.php');</script>");
            }

        } else {
            die("<script>alert('您还没有登录，请登录！');window.location.replace('./index.php');</script>");
        }

    }

    public function GedanManage(){
        require_once('./Model/ProfileModel.php');
        require_once('./Model/GedanManageModel.php');

        if (isset($_COOKIE['user'])) {
            if((new ProfileModel())->getUserInfo(decrypt($_COOKIE['user']))){
                if($_GET['type'] === "ac"){
                    (new GedanManageModel) -> GedanManage_ac(decrypt($_COOKIE['user']));
                    die( "<script>window.location.replace('./?a=GedanManage');</script>");
                }
                if($_GET['type'] === "del"){
                    (new GedanManageModel) -> GedanManage_del(decrypt($_COOKIE['user']));
                    die( "<script>window.location.replace('./?a=GedanManage');</script>");
                }

                $result = (new GedanManageModel) -> GedanManage(decrypt($_COOKIE['user']));
            }
            else{
                die("<script>alert('您还没有登录，请登录！');window.location.replace('./index.php');</script>");
            }
        }
        else {
            die("<script>alert('您还没有登录，请登录！');window.location.replace('./index.php');</script>");
        }

        require_once('./View/GedanManage.html');
    }

}


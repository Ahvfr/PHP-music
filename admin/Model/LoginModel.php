<?php


class LoginModel{

    public function Login($username, $password){

        $conn = new mysqli('localhost', 'root', 'root', 'music');
        $sql = "SELECT password FROM user WHERE username = '$username' AND type = 0";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $result = mysqli_fetch_all($result);
            if(hash('md4',$password) == $result[0][0]){
                return true;
            }
            else{
                return false;
            }

        }

    }


}
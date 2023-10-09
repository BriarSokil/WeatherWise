<?php
    require "dbControl.php";

    function loginUser($login, $loginType, $password)
    {
        $password = hash("sha256", $password);
        if($loginType == '1')//login by phone
        {
            $queryCheck = "select id, name, email, phone, city from user where phone = '{$login}' and password = '{$password}'"; 
        }
        else if ($loginType = '2')//login by email
        {
            $queryCheck = "select id, name, phone, email, cityfrom user where email = '{$login}' and password = '{$password}'";
        }
        $result = dbconnect($queryCheck);
        if(mysqli_num_rows($result) == 1)
        {
            resetSession();
            $row = mysqli_fetch_array($result);
            $_SESSION['login-user-id'] = $row['id'];
            $_SESSION['login-user-name'] = $row['name'];
            $_SESSION['login-user-phone'] = $row['phone'];
            $_SESSION['login-user-email'] = $row['email'];
            $_SESSION['login-user-city'] = $row['city'];
            echo(json_encode(array(
                "id"=>$_SESSION['login-user-id'], 
                "name"=>$_SESSION['login-user-name'],
                "email"=>$_SESSION['login-user-email'], 
                "phone"=>$_SESSION['login-user-phone'],
                "city"=>$_SESSION['login-user-city'], 
                "status"=>"success",
                "message"=>"login success"
            )));
        }
        else
        {
            fail("Login failure");
        }
    }
?>
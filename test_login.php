<?php
    session_start();

    require_once("lib/test_login_lib.php");

    define('LINE_LOGIN_CHANNEL_ID','1612188467');
    define('LINE_LOGIN_CHANNEL_SECRET','5542059538662e028a13babd21083435');
    define('LINE_LOGIN_CALLBACK_URL','https://adglobebot.herokuapp.com/test_login_callback.php');

    $LineLogin = new LineLoginLib(LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);
    echo "here";
    
        echo "here1";
        if(!isset($_SESSION['ses_login_accToken_val'])){    
            $LineLogin->authorize(); 
            exit;
        }
        echo "here2";
        $accToken = $_SESSION['ses_login_accToken_val'];
    
        if($accToken){
            echo $accToken."<br><hr>";
        }
    
        $userInfo = $LineLogin->userProfile($accToken,true);
        if(!is_null($userInfo) && is_array($userInfo) && array_key_exists('userId',$userInfo)){
            echo "<br>userInfo: ";
            print_r($userInfo);
        }
        $_SESSION["userInfo"] = $userInfo;
        echo "<br>";
        echo "<pre>";
        print_r($_SESSION["userInfo"]);
        echo "</pre>";

    if(isset($_POST["lineLogout"])){
        echo "here3";
        $accToken = "";
        unset($_SESSION['ses_login_accToken_val']);
        unset($_SESSION["userInfo"]);

        if($LineLogin->revokeToken($accToken)){
            echo "<script>console.log('log out successful');</script>";
        }
    }
    
    header("Location: index.php");
    exit;
    
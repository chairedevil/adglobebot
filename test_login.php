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
        if(isset($_SESSION['ses_login_userData_val']) && $_SESSION['ses_login_userData_val']!=""){
            $lineUserData = json_decode($_SESSION['ses_login_userData_val'],true);
            $_SESSION["userData"] = [
                "userName" => $lineUserData['name'],
                "userPic" => $lineUserData['picture']
            ];
        }
        echo "<br>userData: ";
        echo "lineUserData: ".$lineUserData."<br>";
        echo "<pre>";
        print_r($_SESSION["userData"]);
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
    
    //header("Location: index.php");
    //exit;

    if($accToken){
    ?>
    <!--<form method="post">
    <button type="submit" name="lineLogout">LINE Logout</button>
    </form>
    <?php }else{ ?>
    <form method="post">
    <button type="submit" name="lineLogin">LINE Login</button>
    </form>   -->
    <?php } ?>

    <?php
    /*
    if(isset($_POST["lineLogin"])){
        $LineLogin->authorize(); 
        exit;
    }else if(isset($_POST["lineLogout"])){
        $accToken = "";
        unset($_SESSION['ses_login_accToken_val']);

        if($LineLogin->revokeToken($accToken)){
            echo "log out successful";
        }
        echo '<form method="post"><button type="submit" name="lineLogin">LINE Login</button></form>';
        $LineLogin->redirect('test_login.php');
        
    }*/
    


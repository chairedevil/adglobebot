<?php
    session_start();

    require_once("lib/LineLoginLib.php");

    define('LINE_LOGIN_CHANNEL_ID','1612188467');
    define('LINE_LOGIN_CHANNEL_SECRET','5542059538662e028a13babd21083435');
    define('LINE_LOGIN_CALLBACK_URL','https://adglobebot.herokuapp.com/test_login_callback.php');

    $LineLogin = new LineLoginLib(LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);

    $dataToken = $LineLogin->requestAccessToken($_GET, true);
    if(!is_null($dataToken) && is_array($dataToken)){
        if(array_key_exists('access_token',$dataToken)){
            $_SESSION['ses_login_accToken_val'] = $dataToken['access_token'];
        }
        if(array_key_exists('refresh_token',$dataToken)){
            $_SESSION['ses_login_refreshToken_val'] = $dataToken['refresh_token'];
        }   
        if(array_key_exists('id_token',$dataToken)){
            $_SESSION['ses_login_userData_val'] = $dataToken['user'];
        }       
    }
    $LineLogin->redirect('test_login.php');
?>
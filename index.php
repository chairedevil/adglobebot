<?php
    session_start();

    require_once("lib/test_login_lib.php");

    $accToken = "";
    $username = "guest";
    $userId = "adglobe";
    if(isset($_SESSION["ses_login_accToken_val"])){
        $accToken = $_SESSION["ses_login_accToken_val"];

        $userInfo = [];
        if(isset($_SESSION["userInfo"])){
            $userInfo = $_SESSION["userInfo"];
            $username = $userInfo["displayName"];
            $userId = $userInfo['userId'];
        }
        /*echo"<pre>";
        print_r($userInfo);
        echo"</pre>";*/
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adglobe Bot</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
    <style>
        body{
            background-color: #05172e;
            font-family: "Rounded Mplus 1c";
        }
        .intro{
            width: 100%;
            object-fit: contain;
        }

        td{
            padding: 20px 10px;
        }
        .card{
            border: none;
            box-shadow: 1px 1px 0px #071b331c;
            margin-bottom: 20px;
        }

        .top_header{
            min-height: 100px;
        }

        .card-header{
            background-color: #244063;
        }

        .main-card{
            width:  100%;
            min-width: 300px;
            height: 100vh;
            margin-bottom: 0;
        }
        .main-card-body{
            overflow-y: auto;
            overflow-x: hidden;
            background-color: rgb(248, 248, 248);
        }

        .msgTime, .msgHeader{
            font-size: 0.6em;
            border: none;
            padding: 3px;
            min-width: 170px;
            background-color: #f18e1e;
            background-color: #3f628e;
            color: #fff;
            padding-left: 10px;
            padding-right: 10px;
        }
        .msgHeader{
            font-size: 0.8em;
            font-weight: 900;
        }

        .instImg{
            border-radius: 0;
        }
        
        .twitter_account{
            font-size: 0.8em;
        }
        .sendBtn{
            background-color: #244063;
            color: #fff;
            font-weight: 900;
        }
        .sendBtn:hover{
            background-color: #3f628e;
        }

        .lineBtn{
            border: none;
            background-image: url(img/btn_login_base.png);
            background-size: cover;
            height: 33px;
            width: 113.625px;
            background-color: transparent;
        }
        .lineBtn:hover{
            background-image: url(img/btn_login_hover.png);
        }
        .lineBtn:active{
            background-image: url(img/btn_login_press.png);
        }

        .profileIcon{
            border-radius: 5px;
            background-image: url(<?= $userInfo["pictureUrl"] ?>);/*profile pic*/
            background-repeat: none;
            background-size: contain;
            height: 50px;
            width: 50px;
            box-shadow: none;
        }

        #logout:hover{
            cursor: pointer;
        }

        @media screen and (min-width: 600px) {
            .main-card{
                margin-top: 5vh;
                height: 90vh;
            }
        }

    </style>
</head>
<body onload="scroll()">
    <div class="container">
        <div class="row">
            <div class="main-card card">
                <div class="card-header text-white d-flex justify-content-center align-items-center top_header">
                    <img class="m-4 mr-auto" src="img/logo_white.png" alt="adglobe">
                    <!--not login-->
                    <?php if($accToken==""){ ?>
                    <button class="lineBtn" onclick="submit('lineLogin')"></button>
                    <form action="test_login.php" method="POST" id="lineLogin">
                        <input type="text" name="lineLogin" value="lineLogin" style="display:none;">
                    </form>
                    <?php }else{ ?>
                    <!--already login-->
                    <div class="dropdown dropleft">
                        <button class="btn btn-secondary dropdown-toggle profileIcon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <p class="dropdown-item" id="logout" onclick="submit('lineLogout')">ログアウト</p>
                                <form action="test_login.php" method="POST" id="lineLogout">
                                    <input type="text" name="lineLogout" value="lineLogout" style="display:none;">
                                </form>
                        </div>
                    </div>
                    <?php } ?>


                </div>
                <div class="card-body main-card-body d-flex">
                    <div class="container displayArea">
                        <img class="intro mb-4" src="img/intro.png">
                        <div class="row justify-content-start mb-1">
                            <div class="card">
                                <div class="card-header msgHeader">Bot</div>
                                <div class="card-body p-2">
                                <p class="card-text msgBody">
                                    <table>
                                        <tr>
                                            <th>翻訳</th>
                                            <td>"#" + 文章又は言葉</td>
                                        </tr>
                                        <tr>
                                            <th>インスタグラムの直近投稿</th>
                                            <td>"i@" + インスタグラムのユーザー名</td>
                                        </tr>
                                        <tr>
                                            <th>ツイッターの直近投稿</th>
                                            <td>"t@" + ツイッターのユーザー名</td>
                                        </tr>
                                        <tr>
                                            <th>ブロードキャスト</th>
                                            <td>"皆に：" + メッセージ</td>
                                        </tr>
                                    </table>
                                </p>
                                    <!--<p class="card-text msgBody">翻訳　→　# + 文章又は言葉</p><br>
                                    <p class="card-text msgBody">インスタグラムの直近投稿　→　"i@" + インスタグラムのユーザー名</p><br>
                                    <p class="card-text msgBody">ツイッターの直近投稿　→　"t@" + ツイッターのユーザー名</p><br>
                                    <p class="card-text msgBody">ブロードキャスト　→　"皆に：" + メッセージ</p><br>-->
                                </div>
                            </div>
                        </div>
                        <!--<div class="row justify-content-start mb-1">
                            <div class="card">
                                <div class="card-header msgHeader">Bot</div>
                                <div class="card-body p-2">
                                    <p class="card-text msgBody">"@" + インスタグラムのユーザー名　→　直近投稿</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="card text-right">
                                <div class="card-header msgHeader">User</div>
                                <div class="card-body p-2">
                                    <p class="card-text msgBody">message A</p>
                                </div>
                                <div class="card-footer text-muted bg-white msgTime">01:00</div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="card" style="max-width: 300px;">
                                <div class="card-header msgHeader">Bot</div>
                                <img src="./img/img.jpg" alt="" class="card-img-top instImg">
                                <div class="card-body p-2">
                                    <p class="card-text">Instagram Caption</p>
                                </div>
                                <div class="card-footer text-muted text-right bg-white msgTime">01:00</div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="card" style="max-width: 300px;">
                                <div class="card-header msgHeader">Bot</div>
                                <img src="./img/img.jpg" alt="" class="card-img-top instImg">
                                <div class="card-body p-2">
                                    <p class="card-text">Tweet Caption</p>
                                    <p class="card-text text-right text-muted font-italic twitter_account">Twitter Account</p>
                                </div>
                                <div class="card-footer text-muted text-right bg-white msgTime">01:00</div>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row m-md-2">
                       <div class="col-9 col-md-10">
                              <input class="form-control" type="text" id="input" autofocus>
                       </div>
                       <div class="col-3 col-md-2">
                           <button  id="sendBtn" class="btn w-100 sendBtn" type=button onclick="sendText()">送信</button>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function scroll(){
            $('.main-card-body').scrollTop($('.main-card-body')[0].scrollHeight);
        };

        function submit(id){
            $("#"+id).submit();
        }

        function getTime(){
            $date = new Date();
            $minute = $date.getMinutes();
            if($date.getMinutes()<10){
                $minute = "0"+$date.getMinutes();
            }
            $time = $date.getHours()+':'+$minute;
            return $time;
        }

        
        document.querySelector("#input").addEventListener("keyup", function(event){
            event.preventDefault();
            
            if(event.keyCode === 13){
                document.querySelector("#sendBtn").click();
            }
        });

        let count = 0;
        
        function sendText(){
            let loadIndicator = false;
            let text = document.querySelector("#input").value;
            if(text){
                //console.log(text);
                let data = new FormData();
                
                let item = {
                    driver: 'web',
                    userId: '<?= $userId ?>',
                    message : text
                };

                for (let key in item) {
                    data.append(key, item[key]);
                }
                
                //console.log(data);
                $.ajax({
                    url: 'https://adglobebot.herokuapp.com/botman.php',
                    data: data,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $sendTime = getTime();
                        $userText = '<div class="row justify-content-end mb-1">';
                        $userText = $userText+'<div class="card text-right">';
                        $userText = $userText+'<div class="card-header msgHeader"><?= $username ?></div>';
                        $userText = $userText+'<div class="card-body p-2">';
                        $userText = $userText+'<p class="card-text msgBody">'+ text +'</p>';
                        $userText = $userText+'</div>';
                        $userText = $userText+'<div class="card-footer text-muted bg-white msgTime">'+ $sendTime +'</div>';
                        $userText = $userText+'</div>';
                        $userText = $userText+'</div>';

                        $('.displayArea').append($userText);
                        $("#input").val("");
                        scroll();
                    },
                    
                    success: function(result){
                        let $indicator = result.messages[0].additionalParameters.type;
                        //console.log($indicator);
                        $replyTime = getTime();
                        
                        if($indicator == 'translate'){
                            $botText = '<div class="row justify-content-start mb-1">';
                            $botText = $botText+'<div class="card" style="max-width: 300px">';
                            $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                            $botText = $botText+'<div class="card-body p-2">';
                            $botText = $botText+'<p class="card-text msgBody">'+　result.messages[0].text　+'</p>';
                            $botText = $botText+'</div>';
                            $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                            $botText = $botText+'</div>';
                            $botText = $botText+'</div>';
                        
                        }else if($indicator == 'instagram'){
                            if(!result.messages[0].additionalParameters.error){
                                $botText = '<div class="row justify-content-start mb-1">';
                                $botText = $botText+'<div class="card" style="max-width: 300px;">';
                                $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                                $botText = $botText+'<img src="'+ result.messages[0].additionalParameters.imgSrc +'" alt="" class="card-img-top instImg" id="imgId'+ count +'">';
                                loadIndicator = true;
                                $botText = $botText+'<div class="card-body p-2">';
                                
                                let captionEnd = (result.messages[0].additionalParameters.caption).length>70?'...</p>':'</p>';
                                $botText = $botText+'<p class="card-text">'+ (result.messages[0].additionalParameters.caption).substring(0,70) + captionEnd;
                                
                                $botText = $botText+'</div>';
                                $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                                $botText = $botText+'</div>';
                                $botText = $botText+'</div>';
                            }else{
                                $botText = '<div class="row justify-content-start mb-1">';
                                $botText = $botText+'<div class="card" style="max-width: 300px">';
                                $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                                $botText = $botText+'<div class="card-body p-2">';
                                $botText = $botText+'<p class="card-text msgBody">'+　result.messages[0].additionalParameters.errMsg　+'</p>';
                                $botText = $botText+'</div>';
                                $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                                $botText = $botText+'</div>';
                                $botText = $botText+'</div>';
                            }
                            
                        }else if($indicator == 'twitter'){
                            if(!result.messages[0].additionalParameters.error){
                                $botText = '<div class="row justify-content-start">';
                                $botText = $botText+'<div class="card" style="max-width: 300px;">';
                                $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                                if(result.messages[0].additionalParameters.media!=null){
                                    $botText = $botText+'<img src="'+ result.messages[0].additionalParameters.media +'" alt="" class="card-img-top instImg" id="imgId'+ count +'">';
                                    loadIndicator = true;
                                }
                                $botText = $botText+'<div class="card-body p-2">';
                                $botText = $botText+'<p class="card-text">'+ result.messages[0].additionalParameters.text +'</p>';
                                $botText = $botText+'<p class="card-text text-right text-muted font-italic twitter_account">-'+ result.messages[0].additionalParameters.name +'-</p>';
                                $botText = $botText+'</div>';
                                $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                                $botText = $botText+'</div>';
                            }else{
                                $botText = '<div class="row justify-content-start mb-1">';
                                $botText = $botText+'<div class="card" style="max-width: 300px">';
                                $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                                $botText = $botText+'<div class="card-body p-2">';
                                $botText = $botText+'<p class="card-text msgBody">'+　result.messages[0].additionalParameters.errMsg　+'</p>';
                                $botText = $botText+'</div>';
                                $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                                $botText = $botText+'</div>';
                                $botText = $botText+'</div>';
                            }
                            
                            
                        }else if($indicator == 'error'){
                            $botText = '<div class="row justify-content-start mb-1">';
                            $botText = $botText+'<div class="card" style="max-width: 300px">';
                            $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                            $botText = $botText+'<div class="card-body p-2">';
                            $botText = $botText+'<p class="card-text msgBody">'+　result.messages[0].text　+'</p>';
                            $botText = $botText+'</div>';
                            $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                            $botText = $botText+'</div>';
                            $botText = $botText+'</div>';
                        }
                        
                        $('.displayArea').append($botText);
                        $botText = "";
                        scroll();
                        console.log(loadIndicator);
                        if(loadIndicator){
                            let imgId = document.querySelector("#imgId"+count);
                            console.log("#imgId"+count);
                            imgId.onload = function(){
                                console.log("loaded");
                                scroll();
                            }
                            count++;
                        }
                    }, error: function(){
                        $replyTime = getTime();
                        $botText = '<div class="row justify-content-start mb-1">';
                        $botText = $botText+'<div class="card" style="max-width: 300px">';
                        $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                        $botText = $botText+'<div class="card-body p-2">';
                        $botText = $botText+'<p class="card-text msgBody">入力エラー！！！</p>';
                        $botText = $botText+'</div>';
                        $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                        $botText = $botText+'</div>';
                        $botText = $botText+'</div>';

                        $('.displayArea').append($botText);
                        $botText = "";
                        scroll();
                    }
                });
            }else{
                console.log("no text");
                $replyTime = getTime();
                $botText = '<div class="row justify-content-start mb-1">';
                $botText = $botText+'<div class="card" style="max-width: 300px">';
                $botText = $botText+'<div class="card-header msgHeader">Bot</div>';
                $botText = $botText+'<div class="card-body p-2">';
                $botText = $botText+'<p class="card-text msgBody">入力してください！！</p>';
                $botText = $botText+'</div>';
                $botText = $botText+'<div class="card-footer text-muted text-right bg-white msgTime">'+ $replyTime +'</div>';
                $botText = $botText+'</div>';
                $botText = $botText+'</div>';

                $('.displayArea').append($botText);
                $botText = "";
                scroll();
            }
            
        }
        
        
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>
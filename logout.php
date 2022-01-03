<?php
session_start();

$_SESSION = array(); //セッション変数初期化

//cookieを削除する
if(isset($_COOKIE["PHPSESSID"])){
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy(); //セッション破棄
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <style>
        .kanri{
            margin-left: auto;
            margin-right: auto;
            width: 800px;
            height: 300px;
            padding: 60px;
            background-color: aliceblue;
            text-align: center;
            border-radius: 2rem;
        }
    </style>
</head>
<body>
    <div class="kanri">
    <h2>ログアウトしました</h2>
    <a href="login.php">ログインページに戻る</a>
    </div>
</body>
</html>
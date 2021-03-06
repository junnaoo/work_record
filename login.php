<?php
    session_start();
    require('utils.php');
    $error_message = '';

    if(isset($_POST['member_num']) && isset($_POST['password'])){

        if(!alphanum_check($_POST['member_num'])){
            //ユーザーIDが英数字以外の場合（空白含む）
            $error_message = 'ユーザーIDまたはパスワードが不正です。';
        }
        if(!alphanum_check($_POST['password'])){
            //パスワードが英数字以外の場合（空白含む）
            $error_message = 'ユーザーIDまたはパスワードが不正です。';
        }

        if(empty($error_message)){
            //エラーが出なければ実行する
            $member_num = $_POST['member_num'];
            $password = $_POST['password'];

            try{
                //DBへの接続
                $dsn = new PDO('mysql:host=localhost; dbname=shift; charset=utf8','root','');
            } catch (PDOException $e){
                //DB接続時エラーの時、エラーメッセージを出力して終了する
                exit($e-getMessage());
            }
            
            //クエリ　POSTされたmember_numと同じIDのパスワードを取得する
            $query = $dsn->prepare('SELECT password FROM user WHERE member_num = :member_num');
            //SQL文をセットした後にパラメータ（:member_num）に値をセットする
            $query->bindValue(':member_num', $member_num, PDO::PARAM_STR);
            //クエリを実行
            $query->execute();
            //結果を取得
            $result = $query->fetch();
            //送信したパスワードとDB上のパスワードを比較する
            if($result !== FALSE && $password === $result['password']){
                //パスワードが一致した場合
                session_regenerate_id(TRUE); //セッション再発行
                $_SESSION['member_num'] = $member_num; //セッション変数にmember_numを格納
                $_SESSION['name'] = $result['name']; 
                header("Location: mypage.php"); //mypage.phpに移動
                exit();
            }else{
                //パスワードが一致しない場合
                $error_message = 'ユーザーIDまたはパスワードが違います。';
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        html {
            font-size: 80%;/*rem算出をしやすくするために*/
        }
        .btn,
        button {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.5;
            position: relative;
            display: inline-block;
            padding: 1rem 4rem;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            text-align: center;
            vertical-align: middle;
            text-decoration: none;
            letter-spacing: 0.1em;
            color: #212529;
            border-radius: 0.5rem;
            border: 0px;
        }
        .btn,
        button{
            background-color: lavender;
        }
        .btn:hover,
        button:hover{
            color: #fff;
            background-color: lightslategray;
        }
        span{
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.5;
        }
        input{
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.5;
            width: 200px;
        }
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
    <form action="" method="post">
        <p><span>社員番号　：</span><input type="text" name="member_num"></p>
        <p><span>パスワード：</span><input type="text" name="password"></p><br>
        
        <?php
            if(!empty($error_message))echo "<p>{$error_message}</p>";
        ?>

        <input type="submit" name="submit" value="ログイン" class="btn">
    </form>
    </div>
</body>
</html>
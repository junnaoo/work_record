<?php
session_start();
if(!isset($_SESSION['member_num'])){
    //セッション変数がない場合ログインページに移動
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠登録</title>
    <style>
                *,
        *:before,
        *:after {
        -webkit-box-sizing: inherit;
        box-sizing: inherit;
        }

        html {

        font-size: 62.5%;/*rem算出をしやすくするために*/
        }

        .btn,
        a.btn,
        button.btn {
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
        }
        .shukkin,
        a.shukkin{
            background-color: lavender;
        }
        .shukkin:hover,
        a.shukkin:hover{
            color: #fff;
            background-color: lightslategray;
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
    <?php
        try{
        //DBへの接続
        $dsn = new PDO('mysql:host=localhost; dbname=shift; charset=utf8','root','');
    } catch (PDOException $e){
        //DB接続時エラーの時、エラーメッセージを出力して終了する
        exit($e-getMessage());
    }
    //クエリ　POSTされたmember_numと同じIDのパスワードを取得する
    $query = $dsn->prepare('SELECT name FROM user WHERE member_num = :member_num');
    //SQL文をセットした後にパラメータ（:member_num）に値をセットする
    $query->bindValue(':member_num', $_SESSION['member_num'], PDO::PARAM_STR);
    //クエリを実行
    $query->execute();
    //結果を取得
    $result = $query->fetch();
    ?>

    <div class="kanri">
    <h2><?php echo $result['name'];?>さん、お疲れ様です。</h2>
    <a href="" class="btn shukkin">出勤</a>
    <a href="" class="btn shukkin">退勤</a><br><br><br>
    <a href="logout.php">ログアウトする</a>  
    </div>
    
</body>
</html>
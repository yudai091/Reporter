<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ユーザー登録完了</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/iscontinu.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <div class="content">
            <p>登録しました</p>
            <input type="button" onclick="location.href='register_users.php'" value="続けて登録する">
            <input type="button" onclick="location.href='mypage.php'" value="戻る">
        </div>
        <?php require_once('footer.php') ?>
    </body>
</html>
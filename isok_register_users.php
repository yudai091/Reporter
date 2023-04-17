<?php
session_start();
require('dbconnect.php');

if (!isset($_SESSION['join'])) {
    header ('Location: config_register_users.php');
    exit();
}

$hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);

if(!empty($_POST)){
    $statement = $db->prepare('INSERT INTO members SET student_id=?, name=?, password=?');
    $statement->execute(array(
        $_SESSION['join']['student_id'],
        $_SESSION['join']['name'],
        $hash));
    unset($_SESSION['join']);
    header ('Location: iscontinu_register_users.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ユーザー登録確認</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/isok_register.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

            <form action="" method="post" id="registrationform">
                <input type="hidden" name="action" value="submit">
                    <p id="list">ユーザー名</p>
                        <p id="about"><?php echo (htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></p>
                    <p id="list">統合認証ID(学籍番号)</p>
                        <p id="about"><?php echo (htmlspecialchars($_SESSION['join']['student_id'], ENT_QUOTES)); ?></p>
                    <p id="list">パスワード</p>
                        <p id="about">[セキュリティのため非表示]</p>
                <input type="button" onclick="location.href='register_users.php?action=rewrite'" value="修正する" name="rewrite">
                <input type="button" value="登録する" name="registration" id="openBtn">
                    <div id="modal" class="modal">
                        <div class="modal_content for_register_u">
                            <p>登録しますか?</p>
                        <input type="submit" id="register" value="はい">
                        <input type="button" id="closeBtn" value="いいえ">
                        </div>
                    </div>
            </form>
            <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/modal.js"></script>
    </body>
</html>
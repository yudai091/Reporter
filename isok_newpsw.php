<?php
session_start();
require('dbconnect.php');

$hash = password_hash($_SESSION['join']['new_password'], PASSWORD_BCRYPT);

if(!empty($_POST)){
    $statement = $db->prepare('UPDATE members SET password=? WHERE student_id=?');
    $statement->execute(array(
        $hash,
        $_SESSION['join']['student_id']
        ));
    header ('Location: chenged_psw.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>新規パスワード設定確認</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/isok_register.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

            <form action="" method="post" id="registrationform">
                <input type="hidden" name="action" value="submit">
                <p id="list">新規パスワード</p>
                        <p id="about">[セキュリティのため非表示]</p>
                    <input type="button" onclick="location.href='setting_psw.php?action=rewrite'" value="修正する" name="rewrite">
                    <input type="button" value="変更する" name="registration" id="openBtn">
                </div>
                    <div id="modal" class="modal">
                        <div class="modal_content for_register">
                            <p>変更しますか?</p>
                        <input type="submit" id="register" value="はい">
                        <input type="button" id="closeBtn" value="いいえ">
                        </div>
                    </div>
            </form>
            <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/modal.js"></script>
    </body>
</html>
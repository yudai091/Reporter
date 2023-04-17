<?php
session_start();
require('dbconnect.php');

if(!empty($_POST)){
    $statement = $db->prepare('UPDATE members SET leader=1 WHERE student_id=?');
    $statement->execute(array(
        $_SESSION['join']['student_id']
        ));
    header ('Location: iscontinu_register_leader.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>管理者登録確認</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/isok_register.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
    </head>
    <body>
        <?php require('header.php') ?>

            <form action="" method="post" id="registrationform">
                <input type="hidden" name="action" value="submit">
                <p id="list">統合認証ID(学籍番号)</p>
                        <p id="about"><?php echo (htmlspecialchars($_SESSION['join']['student_id'], ENT_QUOTES)); ?></p>
                    <input type="button" onclick="location.href='register_leader.php?action=rewrite'" value="修正する" name="rewrite">
                    <input type="button" value="登録する" name="registration" id="openBtn">
                </div>
                    <div id="modal" class="modal">
                        <div class="modal_content for_register_l">
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
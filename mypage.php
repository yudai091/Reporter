<?php
session_start();
require('dbconnect.php');
if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600 > time())) {
    $_SESSION['time'] = time();
    $members=$db->prepare('SELECT * FROM members WHERE student_id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
    } else {
    header('Location: login.php');
    exit();
}
if (!empty($_POST)){
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        $now_gp=date("Y")-1966;
        $message=$db->prepare('INSERT INTO posts SET created_by=?, title=?, message=?, created=NOW(), gp=?');
        $message->execute(array($member['student_id'] , $_POST['title'], $_POST['message'], $now_gp));
        $reset_inc_set=$db->query('SET @i:=0');
        $reset_inc=$db->query('UPDATE posts SET message_id = (@i := @i +1)');
        // require('discord.php');
        header('Location: iscontinu_reports.php');
        exit();
    }else {
        header('Location: login.php');
        exit();
    }
}
$TOKEN_LENGTH = 16;
$tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
$token = bin2hex($tokenByte);
$_SESSION['token'] = $token;
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>マイページ</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/mypage.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <form action='' method="post">
            <input type="hidden" name="token" value="<?=$token?>">
        <?php if (isset($error['login']) &&  ($error['login'] =='token')): ?>
                <p class="error">不正なアクセスです。</p>
        <?php endif; ?>
        <?php require_once('menu.php') ?>
            <div class="edit">
                <div class="content">
                    <p id="ttl">タイトル</p>
                    <textarea name="title" cols='10' rows='1' id="report_title" required><?php echo htmlspecialchars($title??"", ENT_QUOTES); ?></textarea>
                    <p id="about">報告内容</p>
                    <textarea name="message" cols='100' rows='15' id="report_message" required><?php echo htmlspecialchars($message??"", ENT_QUOTES); ?></textarea>
                    <input type="submit" value="報告する" id="report_btn">
                </div>
            </div>
        </form>
        <?php require_once('footer.php') ?>
    </body>
</html>
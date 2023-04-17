<?php
    $now_y=date("Y");
    $now_gp=date("Y", strtotime($now_y));
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>報告完了画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/iscontinu.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <div class="content">
            <p>報告しました</p>
            <input type="button" onclick="location.href='reports.php?gp=<?php echo htmlspecialchars($now_gp-1966, ENT_QUOTES); ?>'" value="確認する">
            <input type="button" onclick="location.href='mypage.php'" value="続けて報告する">
        </div>
        <?php require_once('footer.php') ?>
    </body>
</html>
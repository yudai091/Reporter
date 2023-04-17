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

$indiv_id=$_REQUEST['id'];
$indiv_posts=$db->prepare('SELECT * FROM posts WHERE created_by=? ORDER BY created DESC');
$indiv_posts->execute(array($indiv_id));
$indiv=$db->prepare('SELECT name FROM members WHERE student_id=?');
$indiv->execute(array($indiv_id));
$indiv_name=$indiv->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>報告一覧</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/reports.css"/>
        <link rel="stylesheet" href="css/modal.css"/>
        <link rel="stylesheet" href="css/pagenation.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <?php require('menu.php') ?>
        <p id="indiv_namebox"><a id="back" href="users.php">←戻る</a>
        <span id="indiv_name"><?php echo htmlspecialchars($indiv_name['name'], ENT_QUOTES); ?>さんの報告一覧</span></p>

        <div class="report_content">
            <?php foreach($indiv_posts as $post): ?>
                <div class="indiv_report">
                        <?php if($post['message'] != null): ?> 
                            <p id="title"><?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?></p>
                            <span id="rep"><?php echo nl2br($post['message'], ENT_QUOTES); ?></span>
                                <p id="report_about">報告者: 
                                    <?php echo htmlspecialchars($indiv_name['name'], ENT_QUOTES); ?> | <?php echo htmlspecialchars($post['created'], ENT_QUOTES); ?> |
                                </p> 
                            <?php if($_SESSION['id'] == $post['created_by']): ?>
                                <input type="button" class="openBtn" value="削除">
                                <div id="modal" class="modal modal_del">
                                    <div class="modal_content for_del">
                                        <p>削除しますか?</p>
                                    <a href="delate.php?id=<?php echo htmlspecialchars($post['message_id'], ENT_QUOTES); ?>">
                                        <input type="button" value="はい">
                                    </a>
                                        <input type="button" class="closeBtn" value="いいえ">
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php require_once('footer.php') ?>

        <script type="text/javascript" src="javascript/del_modal.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="javascript/pagenation.js"></script>
        <script type="text/javascript">
            var windowWidth = window.innerWidth;
            var pages;
            if (windowWidth < 767) {
                pages = 4;
            } else {
                pages = 6;
            }
            jQuery(document).ready(function ($) {
                $(".report_content").paginathing({
                perPage: pages,
                firstLast: true,
                firstText: "<<",
                lastText: ">>",
                prevText: "<",
                nextText: ">",
                activeClass: "active",
                });
            });
        </script>
    </body>
</html>
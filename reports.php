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

$gp=$_GET['gp'];
$posts=$db->prepare('SELECT m.name, p.* FROM members m, posts p WHERE m.student_id=p.created_by AND p.gp=? ORDER BY p.created DESC');
$posts->execute(array($gp));
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
        <form action="reports.php" method="get">
            <div class="gp_chbox">
                <div class="gp_box">
            <?php 
                $now_y=date("Y");
                $now_gp=date("Y", strtotime($now_y));
                for($i=$now_gp-1966; $i>$now_gp-1969; $i--){ ?>
                <input id="gp_ch" type="submit" name="gp" value="<?php echo $i; ?>">
            <?php } ?>
                    <p id="gp_ttl"><?php $ch_y=$_GET['gp']+1966; echo $ch_y.'年度の報告'; ?></p>
                </div>
            </div>
        </form>
        <div class="report_content">
            <?php foreach($posts as $post): ?>
                <div class="report">
                    <?php if($post['message'] != null): ?> 
                            <p id="title"><?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?></p>
                                <span id="rep"><?php echo nl2br($post['message'], ENT_QUOTES); ?></span>
                                <p id="report_about">報告者: 
                                    <?php echo htmlspecialchars($post['name'], ENT_QUOTES); ?> | <?php echo htmlspecialchars($post['created'], ENT_QUOTES); ?> |
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
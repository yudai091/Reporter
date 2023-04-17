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
$members=$db->prepare('SELECT * FROM members WHERE student_id=?');
$members->execute(array($_SESSION['id']));
$member=$members->fetch();
$users=$db->query('SELECT * FROM members ORDER BY created DESC');
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ユーザー管理画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/users.css"/>
        <link rel="stylesheet" href="css/pagenation.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <?php require('menu.php') ?>

        <div class="user_content">
            <?php foreach($users as $user): ?>
                <div class="user">
                    <div class="user_about">
                        <span class="about" id="name"><?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?></span>
                        <ul>
                            <li>
                                <span class="about" id="grade">学年:  
                                    <?php 
                                        $grade = substr($user['student_id'],0,2);
                                        $now_year = substr(date("Y"),2,2); 
                                        $now_month = date("n") - 3;
                                        
                                        if($now_month <= 0){
                                            $grade = $now_year - $grade;
                                        }
                                        else{
                                            $grade = $now_year - $grade + 1;
                                        }
                                        if($grade <= 4) {
                                            echo($grade.'年生'); 
                                        }
                                        else{
                                            echo('OB');
                                        }
                                    ?>
                                </span>                
                            </li>
                            <li>
                                <span class="about" id="dp">学科:  
                                    <?php 
                                        $department_num = substr($user['student_id'],3,2); 
                                        $departments=$db->prepare('SELECT department FROM departments WHERE num=?');
                                        $departments->execute(array($department_num));
                                        $department=$departments->fetch();
                                        echo($department['department'].'科'); 
                                    ?>
                                </span>
                            </li>
                            <li>
                                <span class="about" id="day">登録日:  <?php echo htmlspecialchars($user['created'], ENT_QUOTES); ?>~</span>
                            </li>
                            <a id="usr_a"href="indiv_reports.php?id=<?php echo htmlspecialchars($user['student_id'], ENT_QUOTES); ?>">
                                <input type="button" class="indiv_rep" value="報告一覧">
                            </a>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php require('footer.php') ?>

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
            $(".user_content").paginathing({
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
    </bory>
</html>
<?php
session_start();
require('dbconnect.php');
if(!empty($_POST)) {
    if(($_POST['student_id'] != '') && ($_POST['password'] != '')) {
        $login = $db->prepare('SELECT * FROM members WHERE student_id=?');
        $login->execute(array($_POST['student_id']));
        $member=$login->fetch();

        if(password_verify($_POST['password'],$member['password'])) {
            $_SESSION['id'] = $member['student_id'];
            $_SESSION['time'] = time();
            header('Location: mypage.php');
            exit();
        } else {
            $error['login'] = 'failed';
        } 
    } else {
        $error['login'] = 'blank';
    }
}
if(isset($_SESSION['id'])){
    if($_SESSION['time'] + 60*5 > time()){
        header('Location: mypage.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>Reporter</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/login.css"/>
    </head>
    <body>
    <?php require_once('header.php') ?>
        <form action='' method="post" id="registrationform">
            <div class="content">
                <p id="title">ログイン</p>
        <?php if (isset($error['login']) &&  ($error['login'] == 'blank')): ?>
                <p id="error">フォームを入力してください</p>
        <?php endif; ?>
        <?php if( isset($error['login']) &&  $error['login'] == 'failed'): ?>
                <p id="error">もう一度入力して下さい</p>
        <?php endif; ?>
                <div class="flex">
                    <div class="login_form">
                        <div>統合認証ID</div>
                            <input type="text" class="input_tologin" id="student_id" name="student_id" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['student_id']??"", ENT_QUOTES); ?>">
                        <div>パスワード</div>
                            <input type="password" class="input_tologin" id="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                        <div>
                            <input type="submit" id="button" name="button" value="Login">
                        </div>
                    </div>
                    <div class="login_attension">
                        <div>
                            <p>注意</p>
                            <ul>
                                <li>ログインには統合認証ID・パスワードをお使い下さい</li>
                                <li>統合認証ID・パスワードは半角英数字で入力して下さい</li>
                                <li>統合認証ID・パスワードを第三者に開示しないで下さい</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>
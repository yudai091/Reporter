<?php
session_start();
require('dbconnect.php');

    $members=$db->prepare('SELECT * FROM members WHERE student_id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();

    $code=$db->prepare('SELECT * FROM codes');
    $code->execute(array());
    $scode=$code->fetch();

if (!empty($_POST) ){
    if ($_POST['student_id'] == "" || $_POST['password'] == "" || $_POST['password2'] == "") {
        $error['form'] = 'blank';
    }
    if(!password_verify($_POST['password'], $scode['code'])){
        $error['password'] = 'notval';
    }
    if (password_verify($_POST['password'], $scode['code'])){
        if (($_POST['password'] != $_POST['password2']) && ($_POST['password2'] != "")){
            $error['password2'] = 'difference';
        }
    }
    if(empty($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: isok_register_leader.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>管理者登録画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
    </head>
    <body>
        <?php require('header.php') ?>
        <?php require('menu.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">管理者登録</p>
            <?php if (isset($error['form']) && ($error['form'] == "blank")): ?>
                <p class="error"> 全て入力して下さい</p>
            <?php endif; ?>
            <?php if (isset($error['password']) && ($error['password'] == "notval")): ?>
                <p class="error"> 正しく入力して下さい</p>
            <?php endif; ?>
            <?php if (isset($error['password2']) && ($error['password2'] == "difference")): ?>
                <p class="error"> 管理者権限コードと再入力した管理者権限コードが一致しません</p>
            <?php endif; ?>
                <p id="input_key">統合認証ID(学籍番号)</p>
                    <input type="text" id="student_id" name="student_id" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['student_id']??"", ENT_QUOTES); ?>">
                <p id="input_key">管理者権限コード</p>
                    <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                <p id="input_key">管理者権限コード再入力</p>
                    <input type="password" name="password2" pattern="[a-zA-Z0-9]+">

                <input type="submit" value="確認する" id="button">
            </form>
        </div>
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>
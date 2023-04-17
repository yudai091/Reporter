<?php
session_start();
require('dbconnect.php');

    $members=$db->prepare('SELECT * FROM members WHERE student_id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
if (!empty($_POST) ){
    if ($_POST['name'] == "" || $_POST['student_id'] == "" || $_POST['password'] == "" || $_POST['password2'] == "") {
        $error['form'] = 'blank';
    }
    if ($_POST['password'] != "" ) {
        if (strlen($_POST['password'] ) < 6 ) {
            $error['password'] = 'length';
        }
    }
    if (($_POST['password'] != $_POST['password2']) && ($_POST['password2'] != "")){
        $error['password2'] = 'difference';
    }
    if(empty($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: isok_register_users.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ユーザー登録画面</title>
        <?php require_once('meta.php') ?>
        <link rel="stylesheet" href="css/register.css"/>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <?php require_once('menu.php') ?>

        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="registrationform">
                <p id="title">ユーザー登録</p>
            <?php if (isset($error['form']) && ($error['form'] == "blank")): ?>
                <p class="error"> 全て入力して下さい</p>
            <?php endif; ?>
            <?php if (isset($error['password']) && ($error['password'] == "length")): ?>
                <p class="error"> パスワードは6文字以上で指定してください</p>
            <?php endif; ?>
            <?php if (isset($error['password2']) && ($error['password2'] == "difference")): ?>
                <p class="error"> パスワードと再入力したパスワードが一致しません</p>
            <?php endif; ?>
                <p id="input_key">ユーザー名</p>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name']??"", ENT_QUOTES); ?>">
                <p id="input_key">統合認証ID(学籍番号)</p>
                    <input type="text" id="student_id" name="student_id" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['student_id']??"", ENT_QUOTES); ?>">
                <p id="input_key">パスワード</p>
                    <input type="password" id="password" name="password" pattern="[a-zA-Z0-9]+" value="<?php echo htmlspecialchars($_POST['password']??"", ENT_QUOTES); ?>">
                <p id="input_key">パスワード再入力</p>
                    <input type="password" name="password2" pattern="[a-zA-Z0-9]+">
                <input type="submit" value="確認する" id="button">
            </form>
        </div>
        <?php require_once('footer.php') ?>
        <script type="text/javascript" src="javascript/check_preg.js"></script>
    </body>
</html>
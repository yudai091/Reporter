<?php
    date_default_timezone_set('Asia/Tokyo');
    $date = new DateTime('now');
    $week = array( '日', '月', '火', '水', '木', '金', '土' );
    $now_y=date("Y");
    $now_gp=date("Y", strtotime($now_y));
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/hamburger.js"></script>
    <link rel="stylesheet" href="css/menu.css"/>
</head>

    <div id="nav-open">
    <span></span>
    </div>
    <div class="user_info">
        <p id="today_datepc">
            <?php echo '今日は'.$date->format('Y/m/d').'('.$week[date('w')].')'.'です';?></p>
        <p id="user_namepc"><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>さん、ようこそ</P>
        <div id="nav-content">
            <div class="hamburger-top"></div>

            <p id="today_datesp">
                <?php echo '今日は'.$date->format('Y/m/d').'('.$week[date('w')].')'.'です';?></p>
            <p id="user_namesp"><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>さん、ようこそ</P>

            <ul class="menu_index">
                <li title="マイページ"><a href="mypage.php" class="mypage">マイページ</a></li>
                <li title="報告一覧"><a href="reports.php?gp=<?php echo htmlspecialchars($now_gp-1966, ENT_QUOTES); ?>" class="list">報告一覧</a></li>
                <li title="ユーザー一覧"><a href="users.php" class="admi_user">ユーザー一覧</a></li>
            <?php if(isset($member['leader']) && ($member['leader'] == 1)): ?>
                <li title="ユーザー登録"><a href="register_users.php" class="register_user">ユーザー登録</a></li>
                <li title="管理者登録"><a href="register_leader.php" class="register_leader">管理者登録</a></li>
            <?php endif; ?>  
                <li title="パスワード設定"><a href="setting_psw.php" class="psw">パスワード設定</a></li>
                <li title="ログアウト"><a href="logout.php" class="logout">ログアウト</a></li>
            </ul>
        </div>
    </div>
</div>
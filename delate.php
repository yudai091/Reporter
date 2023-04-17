<?php
session_start();
require('dbconnect.php');

$now_y=date("Y");
$now_gp=date("Y", strtotime($now_y))-1966;

if(isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];
    $messages = $db->prepare('SELECT * FROM posts WHERE message_id=?');
    $messages -> execute(array($id));
    $message = $messages->fetch();
    if ($message['created_by'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM posts WHERE message_id=?');
        $del->execute(array($id));
    }
}
$url="reports.php?gp=".$now_gp;
header("Location:". $url );
exit();
?>
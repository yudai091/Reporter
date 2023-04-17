<?php
    $contents = $_POST['message'];
    $title = $_POST['title'];
    $message = array(
    'username' => $member['name'],
    'content'  => "> "."**".$title."**"."\n".$contents
    );

    $webhook_url = 'https://discord.com/api/webhooks/1075407682489548811/CpHsCiPpAgR-7z83ij-IQwFmKVElG_WHqt0PpKsg1SeBjaoDoPKWodO3UHkfBDUJspyl';
    $options = array(
    'http' => array(
    'method' => 'POST',
    'header' => 'Content-Type: application/json',
    'content' => json_encode($message),
    )
    );
    $resp = file_get_contents($webhook_url, false, stream_context_create($options));
?>
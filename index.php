<?php
require_once('data.php');
require_once('init.php');
require_once('functions.php');
require_once('config/config.php');
require_once('db_func.php');

$categories = db_categories($link);
$lots = db_opened_lots($link);


$page_content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

print($layout_content);
?>

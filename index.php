<?php
require_once('init.php');
require_once('db_func.php');

$lots = [];
$categories = db_categories($link);
$lots = db_opened_lots($link);

$page_content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'categories' => $categories,
        'user' => $user
    ]);

print($layout_content);

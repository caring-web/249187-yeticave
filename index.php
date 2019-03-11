<?php
require_once('init.php');
require_once('db_func.php');

$is_home_page = false;
$lots = [];
$lots = db_opened_lots($link);

$page_content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'is_home_page' => true,
        'categories_content' => include_template('categories.php',
            [
                'categories' => $categories
            ]
        ),
        'categories' => $categories,
        'user' => $user
    ]);

print($layout_content);

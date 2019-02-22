<?php
require_once('init.php');
require_once('db_func.php');

$lots = [];
$categories = db_categories($link);
$lot = intval($_GET['id']);
$lot_id = db_lot_id($link, $lot);

$page_content = include_template('lot.php', ['lot_id' => $lot_id, 'lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php',
            [
                'content' => $page_content,
                'title' => $title,
                'categories' => $categories,
                'is_auth' => $is_auth,
                'user_name' => $user_name
            ]);

print($layout_content);

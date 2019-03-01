<?php
require_once('init.php');

$lots = [];
$categories = db_categories($link);

$lot = isset($_GET['id']) ? intval($_GET['id']) : 0;

$lot_id = !empty($lot) ? db_lot_id($link, $lot) : [];

if (empty($lot_id)) {
        $error = [
            'title' => '404 Страница не найдена',
            'message' => 'Данной страницы не существует на сайте.'
        ];
        header("HTTP/1.0 404 Not Found");
        $page_content = include_template('404.php', ['error' => $error, 'categories' => $categories]);
        $layout_content = include_template('layout.php',
            [
                'content' => $page_content,
                'title' => $error['title'],
                'categories' => $categories,
                'user' => $user
            ]);
        print($layout_content);
        exit();
    }

$page_content = include_template('lot.php', ['lot_id' => $lot_id, 'lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'categories' => $categories,
        'user' => $user
    ]);
print($layout_content);

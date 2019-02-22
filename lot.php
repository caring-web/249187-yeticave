<?php
require_once('init.php');
require_once('db_func.php');

$lots = [];
$categories = db_categories($link);

if (isset($_GET['id'])) {
    $lot = intval($_GET['id']);

    if (isset($lot) && !empty($lot)) {
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
        exit();
    }
    else {
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
                'is_auth' => $is_auth,
                'user_name' => $user_name
            ]);
        print($layout_content);
        exit();
    }
}









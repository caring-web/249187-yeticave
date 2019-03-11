<?php
require_once('init.php');

$lots = [];
$categories = db_categories($link);
$data = [];
$errors = [];

// получаем id лота
$lot = isset($_GET['id']) ? intval($_GET['id']) : 0;
// получаем лот по id
$lot_id = !empty($lot) ? db_lot_id($link, $lot) : [];
// получаем массив ставок по лоту
$bets = db_bets($link, $lot);

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
                'is_home_page' => false,
                    'categories_content' => include_template('categories.php',
                        [
                            'categories' => $categories
                        ]
                    ),
                'categories' => $categories,
                'user' => $user
            ]);
        print($layout_content);
        exit();
}

$bet_step = 999999; // максимальный шаг ставки

$show_add_bet = false;

if (!lot_closed($lot_id['date_end'])
    && !empty($user)
    && $user['id'] !== $lot_id['user_id']
    && (empty($bets) || $bets[0]['user_id'] !== $user['id'])) {
    $show_add_bet = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$show_add_bet) {
        header("Location: lot.php?id=" . $lot);
        exit();
    }
    if (isset($_POST['cost']) && !empty(trim($_POST['cost']))) {
        $data['cost'] = trim($_POST['cost']);
    } else {
        $errors['cost'] = 'Это поле обязательно для заполнения!';
    }
    if (empty($errors['cost'])) {
        if (!ctype_digit($data['cost']) || $data['cost'] <= 0) {
            $errors['cost'] = 'Ставка должна быть целым положительным числом';
        } elseif ($data['cost'] < ($lot_id['start_price'] + $lot_id['bet_step'])) {
            $errors['cost'] = 'Ставка должна быть не меньше минимальной';
        } elseif ($data['cost'] - $lot_id['start_price'] > $bet_step) {
            $errors['cost'] = 'Ставка слишком высока. Максимальный шаг ставки - ' . $bet_step . ' р';
            var_dump($errors['cost']);
        }
    }
    if (empty($errors)) {
        $data['user_id'] = $user['id'];
        $data['lot_id'] = $lot;
        $bet_id = db_add_bet($link, $data);
    }
}

$page_content = include_template('lot.php',
    ['lot_id' => $lot_id,
    'lots' => $lots,
    'categories' => $categories,
    'errors' => $errors,
    'show_add_bet' => $show_add_bet,
    'bets' => $bets]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'is_home_page' => false,
            'categories_content' => include_template('categories.php',
                [
                    'categories' => $categories
                ]
            ),
        'categories' => $categories,
        'user' => $user
    ]);
print($layout_content);

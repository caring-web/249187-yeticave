<?php
require_once('init.php');
require_once('config/config.php');

$categories = db_categories($link);
$lot_id = !empty($lot) ? db_lot_id($link, $lot) : [];

//Ограничения полей формы
$lenght_title = 100;
$lenght_description = 750;
$max_price = 99999999;
$max_step_bet = 999999;
$max_file = 1.5;

// Данные из формы
$data = [];
// Ошибки, которые допустил пользователь при заполнении формы
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keys = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $file_name = '';
    foreach ($keys as $key) {
        if (isset($_POST[$key]) && !empty(trim($_POST[$key]))) {
            $data[$key] = trim($_POST[$key]);
        }
        else {
            $errors[$key] = 'Данное поле обязательно для заполнения!';
        }
    }
    if (empty($errors['lot-name']) && strlen($data['lot-name']) > $lenght_title) {
        $errors['lot-name'] = 'Максимальное количество символов - ' . $lenght_title;
    }
    if (empty($errors['category']) && empty(db_categories($link, ['category_id' => mysqli_real_escape_string($link, $data['category'])]))) {
        $errors['category'] = 'Выберите, пожалуйста, категорию!';
        $data['category'] = '';
    }
    if (empty($errors['message']) && strlen($data['message']) > $lenght_description) {
        $errors['message'] = 'Максимальное количество символов - ' . $lenght_description;
    }
    if (empty($errors['lot-rate'])) {
        $data['lot-rate'] = str_replace(',', '.', $data['lot-rate']);
        if (!is_numeric($data['lot-rate']) || $data['lot-rate'] <= 0) {
            $errors['lot-rate'] = 'Цена должна быть положительным числом';
        }
        elseif ($data['lot-rate'] > $max_price) {
            $errors['lot-rate'] = 'Максимальная цена - ' . $max_price . ' р';
        }
        else {
            $data['lot-rate'] = ceil($data['lot-rate']);
        }
    }
    if (empty($errors['lot-step'])) {
        if (!ctype_digit($data['lot-step']) || $data['lot-step'] <= 0) {
            $errors['lot-step'] = 'Шаг ставки должен быть целым положительным числом';
        }
        elseif ($data['lot-step'] > $max_step_bet) {
            $errors['lot-step'] = 'Максимальный шаг ставки - ' . $max_step_bet . ' р';
        }
    }
    if (empty($errors['lot-date'])) {
        $date = strtotime($data['lot-date']);
        $data['lot-date'] = !$date ? $data['lot-date'] : date('Y-m-d', $date);
        if (!$date) {
            $errors['lot-date'] = 'Введите, пожалуйста, корректную дату!';
        }
        elseif (time() >= $date) {
            $errors['lot-date'] = 'Дата окончания лота должна быть минимум на 1 день больше текущей даты';
        }
    }
    if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $file_size = $_FILES['photo']['size'];
        $file_type = mime_content_type($tmp_name);
        if ($file_type !== 'image/png' && $file_type !== 'image/jpeg') {
            $errors['photo'] = 'Загрузите файл в формате jpeg, jpg или png';
        }
        elseif ($file_size > $max_file * 1024 * 1024) {
            $errors['photo'] = 'Максимальный размер файла - ' . $max_file . ' МБ';
        }
        else {
            $file_extension = $file_type === 'image/jpeg' ? '.jpg' : '.png';
            $file_name = uniqid() . $file_extension;
        }
    }
    else {
        $errors['photo'] = 'Загрузите файл с изображением лота';
    }
    if(empty($errors)) {
        $file_dir =  $config['lot_img_path'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $file_dir . $file_name);
        $data['author'] = $user_name;
        $data['file-name'] = $file_name;
        $lot_id = db_add_lot($link, $data);
        header("Location: lot.php?id=" . $lot_id);
    }
}
$page_content = include_template('add-lot.php', [
    'config' => $config,
    'errors' => $errors,
    'data' => $data,
    'categories' => $categories,
    'user_name' => $user_name
]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);
print($layout_content);

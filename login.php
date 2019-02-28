<?php
require_once('init.php');

$categories = db_categories($link);

// Данные из формы
$data = [];
// Ошибки, которые допустил пользователь при заполнении формы
$errors = [];

$length_password = 8;
$name_length = 100;

//Проверяем отправлена ли форма и заполнены ли все обязательные поля
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keys = ['email', 'password'];
    foreach ($keys as $key) {
        if (isset($_POST[$key]) && !empty(trim($_POST[$key]))) {
            $data[$key] = trim($_POST[$key]);
        }
        else {
            $errors[$key] = 'Это поле обязательно для заполнения!';
        }
    }

    if (empty($errors['email'])) {
        //Проверяем корректность адреса электронной почты
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный формат адреса электронной почты';
        }
        //Проверим существование пользователя с email из формы
        $email = mysqli_real_escape_string($link, $data['email']);
        $sql = "SELECT * FROM users WHERE email_user = '$email'";
        $res = mysqli_query($link, $sql);
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!count($errors) and $user) {
            if (password_verify($data['password'], $user['password'])) {
                $_SESSION['user'] = $user['id'];
            }
            else {
                $errors['password'] = 'Неверный пароль';
            }
        }
        else {
            $errors['email'] = 'Такой пользователь не найден';
        }
        if (count($errors)) {
            $page_content = include_template('login.php', ['data' => $data, 'errors' => $errors]);
        }
        else {
            header("Location: index.php");
            exit();
        }
    }
}
$page_content = include_template('login.php', ['data' => $data, 'errors' => $errors, 'categories' => $categories]);
$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'title' => $title,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);
print($layout_content);

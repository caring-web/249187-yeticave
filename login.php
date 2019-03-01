<?php
require_once('init.php');

if(!empty($user)) {
    header("Location: /");
    exit();
}

$categories = db_categories($link);

// Данные из формы
$data = [];
// Ошибки, которые допустил пользователь при заполнении формы
$errors = [];
// Ошибка аутентификации
$is_auth_error = false;

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
        //Проверим существование пользователя с email из формы
        $email = mysqli_real_escape_string($link, $data['email']);
        $sql = "SELECT * FROM users WHERE email_user = '$email'";
        $res = mysqli_query($link, $sql);
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!count($errors) and $user) {
            if (password_verify($data['password'], $user['password_user'])) {
                $_SESSION['user'] = $user['password_user'];
            }
            else {
                $errors['password'] = 'Неверный пароль';
            }
        }
        else {
            $errors['email'] = 'Данный пользователь не найден';
        }
        if(empty($errors) && !$is_auth_error) {
        $_SESSION['user'] = $user;
        header("Location: /");
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
        'user' => $user
    ]);
print($layout_content);

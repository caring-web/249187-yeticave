<?php
require_once('init.php');

if(!empty($user)) {
    header("Location: /");
    exit();
}

// Данные из формы
$data = [];
$user_data = [];
// Ошибки, которые допустил пользователь при заполнении формы
$errors = [];
// Ошибка аутентификации
$is_auth_error = false;

//Проверяем отправлена ли форма и заполнены ли все обязательные поля
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $user_data = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
        if (empty($errors['password'])) {
            if (!empty($user_data) && password_verify($data['password'], $user_data['password_user'])) {
                $user['user_id'] = $user_data['id'];
                $user['name'] = $user_data['name_user'];
                $user['avatar'] = $user_data['avatar_user'];
            } elseif (empty($errors['email'])) {
                $is_auth_error = true;
            }
        }

        if(empty($errors) && !$is_auth_error) {
        $_SESSION['user'] = $user;
        header("Location: /");
        exit();
        }
    }
}
$page_content = include_template('login.php', ['data' => $data, 'errors' => $errors, 'categories' => $categories, 'is_auth_error' => $is_auth_error]);
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

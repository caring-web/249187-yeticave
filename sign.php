<?php
require_once('init.php');

if(!empty($user)) {
    header("Location: /");
    exit();
}

// Данные из формы
$data = [];
// Ошибки, которые допустил пользователь при заполнении формы
$errors = [];

$min_length_password = 8;
$max_length_password = 72;
$name_length = 100;
$message_length = 255;
$avatar_size = 200; //Кб

//Проверяем отправлена ли форма и заполнены ли все обязательные поля
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['email', 'password', 'name', 'message'];
    $file_name = '';
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
        elseif (db_email($link, mysqli_real_escape_string($link, $data['email']))){
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';

        }
    }

    //Проверим длину пароля
    if (empty($errors['password'])) {
        if (strlen($data['password']) < $min_length_password) {
            $errors['password'] = 'Минимальная длина пароля - ' . $min_length_password . ' символов';
        }
        elseif (strlen($data['password']) > $max_length_password) {
            $errors['password'] = 'Максимальная длина пароля - ' . $max_length_password . ' символов';
            }
    }

    if (empty($errors['name']) && strlen($data['name']) > $name_length) {
        $errors['name'] = 'Максимальное количество символов - ' . $name_length;
    }
    if (empty($errors['message']) && strlen($data['message']) > $message_length) {
        $errors['message'] = 'Максимальное количество символов - ' . $message_length;
    }

    if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
       $tmp_name = $_FILES['avatar']['tmp_name'];
       $file_size = $_FILES['avatar']['size'];
       $file_type = mime_content_type($tmp_name);
       if ($file_type !== 'image/png' && $file_type !== 'image/jpeg') {
           $errors['avatar'] = 'Неправильный тип файла. Загрузите файл в формате jpeg, jpg или png';
       }
       elseif ($file_size > $avatar_size * 1024) {
           $errors['avatar'] = 'Размер файла больше допустимого. Максимальный размер - ' . $avatar_size . ' КБ';
       }
       else {
           $file_extension = $file_type === 'image/jpeg' ? '.jpg' : '.png';
           $file_name = uniqid() . $file_extension;
       }
   }


    if(empty($errors)) {
            if(!empty($file_name)) {
                $file_dir = $config['lot_img_path'];
                move_uploaded_file($_FILES['avatar']['tmp_name'], $file_dir . $file_name);
                $data['file-name'] = $file_name;
            }

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $user_id = db_add_user($link, $data);
                    header("Location: login.php");
                    exit();
   }
}

$page_content = include_template('sign-up.php', [
    'config' => $config,
    'errors' => $errors,
    'data' => $data,
    'categories' => $categories,
    'user' => $user
]);
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
?>

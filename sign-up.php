<?php
require_once('init.php');

$categories = db_categories($link);

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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = ['email', 'password', 'name', 'message', 'avatar'];
    foreach ($form as $key) {
        if (isset($_POST[$key]) && !empty(trim($_POST[$key]))) {
            $data[$key] = trim($_POST[$key]);
        }
        else {
            $errors[$key] = 'Данное поле обязательно для заполнения!';
        }
    }

    if (empty($errors['email'])) {
        //Проверяем корректность адреса электронной почты
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный формат адреса электронной почты';
        }
        //Проверим существование пользователя с email из формы
        else {
            $email = mysqli_real_escape_string($link, $form['email']);
            $sql = "SELECT id FROM users WHERE email_user = '$email'";
            $res = mysqli_query($link, $sql);
            if (mysqli_num_rows($res) > 0) {
               $errors[] = 'Пользователь с этим email уже зарегистрирован';
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
            $errors['avatar'] = 'Загрузите, пожалуйста, файл в формате jpeg, jpg или png';
        }
        elseif ($file_size > $avatar_size * 1024) {
            $errors['avatar'] = 'Максимальный размер файла - ' . $avatar_size . ' КБ';
        }
        else {
            $file_extension = $file_type === 'image/jpeg' ? '.jpg' : '.png';
            $file_name = uniqid() . $file_extension;
        }
    }

    if(empty($errors)) {
            if(!empty($file_name)) {
                $file_dir = $init_data['avatar_path'];
                move_uploaded_file($_FILES['avatar']['tmp_name'], $file_dir . $file_name);
                $data['avatar'] = $file_name;
            }

          $password = password_hash($form['password'], PASSWORD_DEFAULT);

          $sql = 'INSERT INTO users (dt_add, email_user, name_user, password_user) VALUES (NOW(), ?, ?, ?)';
          $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password]);
          $res = mysqli_stmt_execute($stmt);
                //Редирект на страницу входа, если пользователь был успешно добавлен в БД
                if ($res && empty($errors)) {
                    header("Location: /login.php");
                    exit();
                }
   }
}

$page_content = include_template('sign-up.php', [
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
?>

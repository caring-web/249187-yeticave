<?php
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param mysqli $link  Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);
    if ($data) {
        $types = '';
        $stmt_data = [];
        foreach ($data as $value) {
            $type = null;
            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }
            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }
        $values = array_merge([$stmt, $types], $stmt_data);
        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }
    return $stmt;
}

/**
 * Возвращает массив категорий
 * @param mysqli $link идентификатор подключения к MySQL
 * @return array массив категорий
 */
function db_categories($link) {
    $result = [];
    $sql = 'SELECT id, category FROM categories';
    if ($query = mysqli_query($link, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return $result;
}

/**
 * Возвращает массив открытых лотов
 * @param mysqli $link идентификатор подключения к MySQL
 * @param int $category_id ID категории лота
 * @return array массив открытых лотов
 */
function db_opened_lots($link) {
    $result = [];
    $sql =
    'SELECT l.name, l.start_price, l.img_lot, l.id, c.category AS category_name FROM lots l
    JOIN categories c
    ON l.category_id = c.id
    ORDER BY l.date_start DESC LIMIT 9';
    if ($query = mysqli_query($link, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return $result;
}

/**
 * Возвращает лот по id
 * @param $link ресурс соединения
 * @param $lot номер лота, который надо получить
 * @return лот по id из БД
 */
function db_lot_id ($link, $lot) {
    $sql = "SELECT lots.*,
            categories.category AS category_name
            FROM lots
            JOIN categories ON lots.category_id = categories.id
            WHERE lots.id = " . $lot;
    $result = mysqli_query($link, $sql);
    if ($result !== false) {
        $lot_id = mysqli_fetch_assoc($result);
    }
    return $lot_id;
}

/**
 * Выполняет запись новой строки в таблицу lots базы данных на основе переданных данных и возвращает идентификатор этой строки
 *
 * @param mysqli $link Идентификатор подключения к серверу MySQL
 * @param array $data Массив данных для подготовленного выражения
 * @return string Идентификатор записанной строки
 */
function db_add_lot($link, $data) {
    $lot_id = '';
    $sql =
        "INSERT INTO lots (name, description, img_lot, date_start, date_end, bet_step, category_id, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = db_get_prepare_stmt($link, $sql, [
        $data['lot-name'],
        $data['message'],
        $data['file-name'],
        $data['lot-rate'],
        $data['lot-date'],
        $data['lot-step'],
        $data['category'],
        $data['author']
    ]);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $lot_id = mysqli_insert_id($link);
    }
    else {
        exit('Произошла ошибка. Попробуйте снова или обратитесь к администратору.');
    }
    return $lot_id;
}

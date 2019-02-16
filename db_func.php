<?php
/**
 * Возвращает массив категорий
 *
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
 *
 * @param mysqli $link идентификатор подключения к MySQL
 * @param int $category_id ID категории лота
 * @return array массив открытых лотов
 */
function db_opened_lots($link) {
    $result = [];
    $sql =
    'SELECT l.name, l.start_price, l.img_lot, c.category AS category_name FROM lots l
    JOIN categories c
    ON l.category_id = c.id
    ORDER BY l.date_start DESC';
    if ($query = mysqli_query($link, $sql)) {
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    return $result;
}
?>

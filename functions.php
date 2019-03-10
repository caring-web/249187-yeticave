<?php
/**
 * Проверяет существование/доступность для чтения файла шаблона, подключает файл шаблона, передает ему данные в буфере вывода
 * Возвращает сгенерированный HTML, если файл шаблона существует/доступен для чтения, иначе вернет false
 * @param string $name - имя файла шаблона
 * @param array $data - ассоциативный массив с данными для шаблона
 * @return false|string
 */
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

/**
 * Округляет цену лота, форматирует разбиением на разряды и добавляет к ней знак рубля
 *
 * @param float $summ - цена, заданная пользователем для лота
 * @return string
 */
function formatPrice ($summ) {
    $summ = ceil($summ);
    if ($summ > 1000) {
        $summ = number_format($summ, 0, ',', ' ');
    }
    return $summ . '<b class="rub">р</b>';
};
/**
 * Возвращает временной промежуток до скрытия лота в формате вида "ЧЧ:ММ"
 *
 * @return string
 */
function get_lot_time() {
    $cur_date = date_create('now');
    $next_day = date_create('tomorrow');
    $diff = date_diff($cur_date, $next_day);
    return date_interval_format($diff,"%H:%I");
};

/**
 * Проверяет не закончился ли аукцион по данному лоту
 *
 * @param string $date_end Дата окончания торгов
 * @return bool true - аукцион закончился, false - аукцион продолжается
 */
function lot_closed($date_end)
{
    return time() >= strtotime($date_end);
}

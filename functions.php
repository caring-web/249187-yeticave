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

/**
 * Возвращает время, прошедшее с момента добавления ставки, или непосредственно время добавления ставки в удобочитаемом формате
 *
 * @param string $adding_time Дата и время добавления ставки
 * @return string Отформатированное время добавления ставки
 */
function get_bet_time($adding_time)
{
    $add_time = strtotime($adding_time);
    $result = date('d.m.y в H:i', $add_time);
    if ($add_time > time()) {
        return 'Ошибка! Время больше текущего';
    }
    $seconds_passed = time() - $add_time;
    $days_passed = (int) floor($seconds_passed / 86400);
    $hours_passed = (int) floor(($seconds_passed % 86400) / 3600);
    $minutes_passed = (int) floor(($seconds_passed % 3600) / 60);
    if ($add_time >= strtotime('yesterday')) {
        $result = sprintf('Вчера в %s', date('H:i', $add_time));
    }
    if ($add_time >= strtotime('today')) {
        $result = sprintf('Сегодня в %s', date('H:i', $add_time));
    }
    if ($days_passed === 0) {
        if ($hours_passed === 0 && $minutes_passed === 0) {
            $result = $seconds_passed <= 30 ? 'Только что' : 'Минута назад';
        } elseif ($hours_passed === 0) {
            $result = $minutes_passed === 1 ? 'Минута назад' : sprintf('%d %s назад', $minutes_passed, num_format($minutes_passed, 'minute'));
        } elseif ($hours_passed > 0 && $hours_passed <= 10) {
            $result = $hours_passed === 1 ? 'Час назад' : sprintf('%d %s назад', $hours_passed, num_format($hours_passed, 'hour'));
        }
    }
    return $result;
}

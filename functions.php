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
 * Проверяет не закончился ли аукцион по данному лоту
 *
 * @param string $date_end Дата окончания торгов
 * @return bool true - аукцион закончился, false - аукцион продолжается
 */
function lot_closed($date_end) {
    return time() >= strtotime($date_end);
};

/**
 * Возвращает временной промежуток до скрытия лота в формате вида "ЧЧ:ММ"
 * @param string $end_lot - дата скрытия лота
 * @return string
 */
function get_lot_time($end_lot = 'tomorrow') {
    $timestamp_lot_life = strtotime($end_lot) - time();
    if ($timestamp_lot_life < 0) {
        $formatted_interval_lot_life = '-- : --';
        return $formatted_interval_lot_life;
    }
    else {
        $hours_lot_life = floor($timestamp_lot_life / 3600);
        $minutes_lot_life = floor(($timestamp_lot_life % 3600) / 60);
        if ($hours_lot_life < 10) {
            $hours_lot_life = '0' . $hours_lot_life;
        }
        if ($minutes_lot_life < 10) {
            $minutes_lot_life = '0' . $minutes_lot_life;
        }
        $formatted_interval_lot_life = $hours_lot_life . ':' . $minutes_lot_life;
        return $formatted_interval_lot_life;
        }
};

/**
 * Возращает дату совершения ставки в зависимости от того, сколько прошло времени с момента совершения ставки
 * @param string $adding_time - дата совершения ставки из БД
 * @return false|string
 */
function get_bet_time($adding_time) {
    $period = time() - strtotime($adding_time);
    $period_in_minutes = floor($period / 60);
    $period_in_hours = floor($period / 3600);
    $yesterday = date('d.m.y', strtotime('Yesterday'));
    $date_bid = date('d.m.y', strtotime($adding_time));
    $minute_forms = ['минуту назад', 'минуты назад', 'минут назад'];
    $hour_forms = ['час назад', 'часа назад', 'часов назад'];
    switch (true) {
        case ($date_bid === $yesterday):
            return 'Вчера, в' . ' ' . date ('H:i', strtotime($adding_time));
            break;
        case ($period < 60):
            return 'только что';
        case ($period < 3600):
            return $period_in_minutes . ' ' . nounEnding($period_in_minutes, $minute_forms);
        case ($period < 86400):
            return $period_in_hours . ' ' . nounEnding($period_in_hours, $hour_forms);
        default:
            return date ('d.m.y в H:i', strtotime($adding_time));
    }
};

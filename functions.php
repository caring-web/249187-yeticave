<?php
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

function formatPrice ($summ) {
    $summ = ceil($summ);
    if ($summ > 1000) {
        $summ = number_format($summ, 0, ',', ' ');
    }
    return $summ . '<b class="rub">р</b>';
};

function get_lot_time() {
    $cur_date = date_create('now');
    $next_day = date_create('tomorrow');
    $diff = date_diff($cur_date, $next_day);
    return date_interval_format($diff,"%H:%I");
};

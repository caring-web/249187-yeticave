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
    return $summ . ' ' . '<b class="rub">р</b>';
};

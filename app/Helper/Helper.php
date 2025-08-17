<?php
function currency_format($number, $suffix = 'đ') {
    return number_format($number ?? 0, 0, ',', '.') . "{$suffix}";
}
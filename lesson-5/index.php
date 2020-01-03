<?php

$rolesArr = ['admin', 'editor'];

$includesArr = [
    'admin'  => ['articles', 'comments', 'statistics'],
    'editor' => ['articles', 'comments'],
];


$roleRequest    = $_GET['role'] ?? null;
$includeRequest = $_GET['includes'] ? explode(',', $_GET['includes']) : null;

if (!$roleRequest || !in_array($_GET['role'], $rolesArr)) {
    header('HTTP/1.0 403 Forbidden');
    $errorCode = http_response_code();
    die ($errorCode . ' Неизвестный уровень доступа. Доступ запрещен!');
}

if (!$includeRequest || !empty(array_diff($includeRequest, $includesArr[$roleRequest]))) {
    header('HTTP/1.0 400 Bad Request');
    $errorCode = http_response_code();
    echo $errorCode . ' Неверный запрос!';
} else {
    header('HTTP/1.0 200 OK');
    $errorCode = http_response_code();
    echo $errorCode . ' Данные успешно получены.';
}

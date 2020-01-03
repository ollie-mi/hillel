<?php

$userIP = $_SERVER['REMOTE_ADDR'] ?? null;

if ($userIP) {
    echo 'User IP is ' . $userIP . '</br><a href="https://check-host.net/ip-info?host=' . $userIP . '" target="_blank">Click here to get information</a>';
} else {
    $error = stripslashes('Something went wrong! Can\'t get user IP or IP is not valid!');
    echo $error;
}
<?php

$getIP = trim($_GET['ip']) ?? null;

if ($getIP && filter_var($getIP, FILTER_VALIDATE_IP)) {
    echo 'User IP is ' . $getIP . '</br><a href="https://check-host.net/ip-info?host=' . $getIP . '" target="_blank">Click here to get information</a>';
} else {
    $error = stripslashes('Something went wrong! Can\'t get user IP or IP is not valid!');
    echo $error;
}
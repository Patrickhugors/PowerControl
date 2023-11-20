<?php
session_start();

$cookies = $_COOKIE;

foreach($cookies as $key => $value) {
    setcookie($key, '', time() - 3600, '/');
}

header("Location: ../src/html/login.html");
exit;
?>

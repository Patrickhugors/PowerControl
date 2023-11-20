<?php
session_start();

$cookies = $_COOKIE;

if (!isset($_COOKIE['id_usuario'])) {
    
    header("Location: ../src/html/login.html");
    exit;
}
?>
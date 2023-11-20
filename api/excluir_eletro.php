<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo)) {
    
  header("Location: ../src/html/login.html");
  exit;
}

$selectedItemId = $_POST['id'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
  die('A conexão falhou: ' . $mysqli->connect_error);
} else {
  $stmt = $mysqli->prepare("DELETE FROM eletro WHERE id = ?");
  $stmt->bind_param("i", $selectedItemId);
  $stmt->execute();
  $stmt->close();
  $mysqli->close();
}
?>

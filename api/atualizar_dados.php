<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
    echo "<script>
    window.location.href = '../src/html/novo.html';
    </script>"; 
  exit;
}

$selectedItemId = $_POST['id'];
$consumo = $_POST['consumo'];
$horas = $_POST['horas'];
$quantidade = $_POST['quantidade'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
  die('A conexão falhou: ' . $mysqli->connect_error);
} else {
  $stmt = $mysqli->prepare("UPDATE eletro SET consumo = ?, horas = ?, quantidade = ? WHERE id = ?");
  $stmt->bind_param("sssi", $consumo, $horas, $quantidade, $selectedItemId);
  $stmt->execute();
  $stmt->close();
  $mysqli->close();
}
?>

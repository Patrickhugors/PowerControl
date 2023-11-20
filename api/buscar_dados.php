<?php
session_start();
$login_ativo = $_SESSION['id_usuario'];

$selectedItemId = $_POST['id'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
  die('A conexão falhou: ' . $mysqli->connect_error);
} else {
  $stmt = $mysqli->prepare("SELECT consumo, horas, quantidade FROM eletro WHERE id = ?");
  $stmt->bind_param("i", $selectedItemId);
  $stmt->execute();
  $stmt->bind_result($consumo, $horas, $quantidade);
  $stmt->fetch();

  $dados = array(
    'consumo' => $consumo,
    'horas' => $horas,
    'quantidade' => $quantidade
  );

  echo json_encode($dados);

  $stmt->close();
  $mysqli->close();
}
?>

<?php
session_start();
$login_ativo = $_SESSION['id_usuario'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
} else {
    $stmt = $mysqli->prepare("SELECT id, nome, consumo, horas, quantidade FROM eletro WHERE id_usuario = ?");
    $stmt->bind_param("i", $login_ativo);
    $stmt->execute();
    $stmt->bind_result($id, $nome, $consumo, $horas, $quantidade);

    $options = '<option value="" selected>Selecione um item</option>';
    while ($stmt->fetch()) {
        $options .= "<option value='$id'>$nome</option>";
    }
    

    $stmt->close();
    $mysqli->close();
}

echo $options;
?>

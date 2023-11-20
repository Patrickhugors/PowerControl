<?php

$idUsuario = $_COOKIE['id_usuario'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");
if ($mysqli->connect_errno) {
    echo json_encode(array('error' => 'Falha ao conectar ao MySQL: ' . $mysqli->connect_error));
    exit();
}

$sql = "SELECT image_data FROM user_images WHERE id_usuario = ? ORDER BY id DESC LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$stmt->bind_result($imageData);

if ($stmt->fetch()) {
    echo json_encode(array('caminhoImagem' => base64_encode($imageData)));
}

$stmt->close();
$mysqli->close();
?>

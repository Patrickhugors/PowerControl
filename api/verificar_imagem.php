<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    echo json_encode(array('caminhoImagem' => '../assets/images/default_image.jpg'));
    exit;
}

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
    // Envia os dados da imagem como base64
    echo json_encode(array('caminhoImagem' => base64_encode($imageData)));
} else {
    // Se não houver imagem, retorna a imagem padrão
    $defaultImage = file_get_contents("../assets/images/default_image.jpg");
    echo json_encode(array('caminhoImagem' => base64_encode($defaultImage)));
}

$stmt->close();
$mysqli->close();
?>

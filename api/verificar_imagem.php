<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
    echo "<script>
    window.location.href = '../src/html/novo.html';
    </script>"; 
  exit;
}

$idUsuario = $_COOKIE['id_usuario'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");
if ($mysqli->connect_errno) {
    echo json_encode(array('error' => 'Falha ao conectar ao MySQL: ' . $mysqli->connect_error));
    exit();
}

$sql = "SELECT caminho FROM imagem WHERE id_usuario = $idUsuario order by 1 desc";
$resultado = $mysqli->query($sql);
if ($resultado->num_rows > 0) {
    $caminhoImagem = $resultado->fetch_assoc()['caminho'];

    echo json_encode(array('caminhoImagem' => $caminhoImagem));
} else {
    echo json_encode(array('caminhoImagem' => 'sem_imagem'));
}
$mysqli->close();
?>

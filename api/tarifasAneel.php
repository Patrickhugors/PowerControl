<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
    echo "<script>
    window.location.href = '../src/html/login.html';
    </script>"; 
  exit;
}

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
} else {
    $stmt = $mysqli->prepare("SELECT id_tarifa_aneel, distribuidora, UF, tarifa FROM tarifasaneel");
    $stmt->execute();
    $stmt->bind_result($id_tarifa_aneel, $distribuidora, $UF, $tarifa);

    $options = '<option value="" selected>Selecione uma Distribuidora</option>';
    while ($stmt->fetch()) {
        $options .= "<option value='$id_tarifa_aneel' data-distribuidora='$distribuidora' data-uf='$UF' data-tarifa='$tarifa'>$distribuidora</option>";
    }

    $stmt->close();
    $mysqli->close();
}

echo $options;
?>

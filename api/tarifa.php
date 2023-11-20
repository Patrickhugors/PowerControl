<?php

$login_ativo = $_COOKIE['id_usuario'];
$valor = isset($_POST['tarifa']) ? str_replace(',', '.', $_POST['tarifa']) : '';
$companhia = isset($_POST['nomeDistribuidora']) ? $_POST['nomeDistribuidora'] : '';
$UF = isset($_POST['uf']) ? $_POST['uf'] : '';

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

// Verificar a conexão
if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
}

// Preparar a declaração SQL
if ($stmt = $mysqli->prepare("INSERT INTO tarifa (valor, companhia, id_usuario, UF) VALUES (?, ?, ?, ?)")) {
    // Vincular parâmetros e tipos
    $stmt->bind_param("dsss", $valor, $companhia, $login_ativo, $UF);
    
    // Executar a declaração
    $stmt->execute();

    // Verificar se a inserção foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        echo "<script>
            alert('Tarifa registrada com sucesso!');
            window.location.href = '../src/html/config.html';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao registrar tarifa!');
            window.location.href = '../src/html/tarifa.html';
        </script>";
    }

    // Fechar a declaração
    $stmt->close();
} else {
    // Se houver um erro na preparação da declaração
    die('Erro na preparação da declaração: ' . $mysqli->error);
}

// Fechar a conexão
$mysqli->close();
?>

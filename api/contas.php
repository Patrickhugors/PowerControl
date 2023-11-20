<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
  header("Location: ../src/html/login.html");
  exit;
}

if (!isset($_COOKIE['id_usuario'])) {
    echo "Você precisa estar logado para acessar esta página.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $_POST['valor'];
    $valor = str_replace(',', '.', $valor);
    $mes = $_POST['mes'];
    $idUsuario = $_COOKIE['id_usuario'];

    $mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

    if ($mysqli->connect_error) {
        die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
    }

    $verificacao = $mysqli->prepare("SELECT COUNT(*) FROM contas WHERE mes = ? AND id_usuario = ?");
    $verificacao->bind_param("ss", $mes, $idUsuario);
    $verificacao->execute();
    $verificacao->bind_result($count);
    $verificacao->fetch();
    $verificacao->close();

    if ($count > 0) {
        $consulta = $mysqli->prepare("UPDATE contas SET valor = ? WHERE mes = ? AND id_usuario = ?");
        $consulta->bind_param("dss", $valor, $mes, $idUsuario);
    } else {
        $consulta = $mysqli->prepare("INSERT INTO contas (valor, mes, id_usuario) VALUES (?, ?, ?)");
        $consulta->bind_param("dss", $valor, $mes, $idUsuario);
    }

    if ($consulta->execute()) {
        echo '<script>alert("Conta de luz inserida/atualizada com sucesso!"); window.location.href="../src/html/config.html";</script>';
    } else {
        echo '<script>alert("Ocorreu um erro ao inserir/atualizar a conta de luz."); window.location.href="../src/html/config.html";</script>';
    }

    $consulta->close();
    $mysqli->close();
}
?>

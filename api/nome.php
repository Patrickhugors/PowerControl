<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
    echo "<script>
    window.location.href = '../src/html/login.html';
    </script>"; 
  exit;
}
$novo_nome = $_POST['novo_nome'];
$senha = $_POST['senha'];

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
} else {
    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE id = ? AND senha = ?");
    $stmt->bind_param("ss", $login_ativo, $senha);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        $stmt = $mysqli->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
        $stmt->bind_param("ss", $novo_nome, $login_ativo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('nome atualizado com sucesso!');
                window.location.href = '../src/html/config.html';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao atualizar o nome!');
                window.location.href = '../src/html/nome.html';
            </script>";
        }
    } else {
        echo "<script>
            alert('Senha incorreta!');
            window.location.href = '../src/html/nome.html';
        </script>";
    }

    $stmt->close();
    $mysqli->close();
}
?>

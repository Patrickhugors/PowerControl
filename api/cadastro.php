<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo)) {
    
  header("Location: ../src/html/login.html");
  exit;
}
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

    if ($mysqli->connect_error) {
        die('A conexao falhou : ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("SELECT login FROM usuarios WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            echo "<script>
                alert('Email já cadastrado no sistema');
                window.location.href = '../src/html/cadastro.html';
            </script>";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, login, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $login, $senha);
            $stmt->execute();
            echo "<script>
                alert('Registro feito com sucesso');
                window.location.href = '../src/html/login.html';
            </script>";
            $stmt->close();
            $mysqli->close();
        }
    }
?>

<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    echo "<script>
    window.location.href = '../src/html/novo.html';
    </script>";  
    }
    
    $nome = $_POST['eletrodomestico']; 
    $consumo = $_POST['consumo'];
    $horas = $_POST['horas'];
    $quantidade = $_POST['quantidade'];

    $mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

    if ($mysqli->connect_error) {
        die('A conexao falhou : ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO eletro (nome, consumo, horas, quantidade, id_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $nome, $consumo, $horas, $quantidade, $login_ativo);
        $stmt->execute();
        echo "<script>
            alert('Produto adicionado com sucesso');
            window.location.href = '../src/html/novo.html';
        </script>";
        $stmt->close();
        $mysqli->close();
    }
?>

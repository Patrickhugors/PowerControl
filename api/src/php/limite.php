<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $limite = isset($_POST['limite']) ? str_replace(',', '.', $_POST['limite']) : '';

    $mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

    if ($mysqli->connect_error) {
        die('A conexão falhou: ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("INSERT INTO limite (valorprevisto) VALUES (?)");
        $stmt->bind_param("d", $limite);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('Limite previsto registrado com sucesso!');
                window.location.href = '../html/config.html';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao registrar o limite previsto!');
                window.location.href = '../html/limite.html';
            </script>";
        }

        $stmt->close();
        $mysqli->close();
    }
}
?>

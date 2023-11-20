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
        $stmt = $mysqli->prepare("SELECT nome, consumo FROM eletro WHERE id_usuario = ?");
        $stmt->bind_param("i", $login_ativo);
        $stmt->execute();
        $stmt->bind_result($nome, $consumo);

        while ($stmt->fetch()) {
            echo "<li><span class='item-name'>&nbsp;$nome</span> <span class='item-usage'>Uso mensal: $consumo h</span></li>";
        }
         

        $stmt->close();
        $mysqli->close();
    }
?>

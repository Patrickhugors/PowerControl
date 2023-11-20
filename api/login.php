<?php
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

    if ($mysqli->connect_error) {
        die('A conexão falhou: ' . $mysqli->connect_error);
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            if ($data['senha'] === $senha) {
                setcookie('id_usuario', $data['id'], time() + (86400 * 30), "/"); 
                header("Location: ../src/html/perfil.html");
                exit();
            } else {
                echo "<script>
                    alert('E-mail ou senha inválida');
                    window.location.href = '../src/html/login.html';
                </script>";
            }
        } else {
            echo "<script>
                alert('E-mail ou senha inválida');
                window.location.href = '../src/html/login.html';
            </script>";
        }
    }
?>

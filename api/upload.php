<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
    echo "<script>
    window.location.href = '../src/html/novo.html';
    </script>"; 
  exit;
}

$conn = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {

        $image_data = file_get_contents($_FILES["image"]["tmp_name"]);

        $image_name = basename($_FILES["image"]["name"]);

        $stmt = $conn->prepare("INSERT INTO user_images (id_usuario, image_name, image_data) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $login_ativo, $image_name, $image_data);
        
        if ($stmt->execute()) {
            echo "Imagem enviada com sucesso e salva no banco de dados.";
        } else {
            echo "Erro ao enviar imagem: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "O arquivo enviado não é uma imagem válida.";
    }
}

$conn->close();
?>

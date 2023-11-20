<?php

$login_ativo = $_COOKIE['id_usuario'];

$conn = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {

    // Verifica erros no upload
    if ($_FILES["image"]["error"] > 0) {
        echo "Erro no upload do arquivo: " . $_FILES["image"]["error"];
        exit;
    }

    // Verifica se é uma imagem válida
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "O arquivo enviado não é uma imagem válida.";
        exit;
    }

    // Verifica se o tipo de imagem é permitido
    $allowed_image_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
    if (!in_array($check[2], $allowed_image_types)) {
        echo "Apenas arquivos de imagem JPEG, PNG ou GIF são permitidos.";
        exit;
    }

    // Prepara a declaração para evitar injeção SQL
    $stmt = $conn->prepare("INSERT INTO user_images (id_usuario, image_name, image_data) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $login_ativo, $image_name, $image_data);

    // Obtém dados da imagem
    $image_data = file_get_contents($_FILES["image"]["tmp_name"]);
    $image_name = basename($_FILES["image"]["name"]);

    // Executa a declaração preparada
    try {
        if ($stmt->execute()) {
            echo "<script>
            alert('Imagem salva com sucesso.');
            window.location.href = '../src/html/perfil.html';
            </script>";
        } else {
            echo "<script>
            alert('Erro ao salvar imagem.');
            window.location.href = '../src/html/perfil.html';
            </script>";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }

    $stmt->close();
}

$conn->close();
?>

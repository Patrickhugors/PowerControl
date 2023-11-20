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
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT titulo, data FROM evento WHERE id_usuario = ?");
$stmt->bind_param("i", $login_ativo);
$stmt->execute();
$result = $stmt->get_result();

$eventos = array();
while ($row = $result->fetch_assoc()) {
  $eventos[] = array(
    'title' => $row['titulo'],
    'start' => $row['data']
  );
}

$response = array(
  'success' => true,
  'eventos' => $eventos
);

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>

<?php

$login_ativo = $_COOKIE['id_usuario'];

if (!isset($login_ativo) || empty($login_ativo)) {
    
    echo "<script>
    window.location.href = '../src/html/novo.html';
    </script>"; 
  exit;
}
$idUsuario = $_COOKIE['id_usuario'];

$conn = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$sql = "SELECT mes, valor FROM contas WHERE id_usuario = $idUsuario order by mes";
$result = $conn->query($sql);

$labels = array();
$valores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row["mes"];
        $valores[] = $row["valor"];
    }
}

$conn->close();

$response = array(
    'labels' => $labels,
    'valores' => $valores
);

header('Content-Type: application/json');
echo json_encode($response);
?>

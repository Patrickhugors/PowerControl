<?php

$login_ativo = $_COOKIE['id_usuario'];

$conn = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$meses = array(
    '01' => "Janeiro",
    '02' => "Fevereiro",
    '03' => "Março",
    '04' => "Abril",
    '05' => "Maio",
    '06' => "Junho",
    '07' => "Julho",
    '08' => "Agosto",
    '09' => "Setembro",
    '10' => "Outubro",
    '11' => "Novembro",
    '12' => "Dezembro"
);

$stmt = $conn->prepare("SELECT mes, valor FROM contas WHERE id_usuario = ? ORDER BY mes");
$stmt->bind_param("i", $login_ativo);
$stmt->execute();
$result = $stmt->get_result();

$contas = array();
while ($row = $result->fetch_assoc()) {
    $mes = $meses[$row['mes']];
    $contas[] = $mes . " - R$" . $row['valor'];
}

$response = array(
    'success' => true,
    'contas' => $contas
);

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>

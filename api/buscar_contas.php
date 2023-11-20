<?php
$login_ativo = $_COOKIE['id_usuario'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clientes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Mapear os números dos meses aos nomes dos meses em português
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

// Consultar as contas do banco de dados e ordená-las pelo valor do mês
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

// Retornar as contas como JSON
header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>

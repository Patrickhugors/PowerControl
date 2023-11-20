<?php

$idUsuario = $_COOKIE['id_usuario'];

function obterUltimoValorTarifa($conexao, $idUsuario) {
  $query = "SELECT valor FROM tarifa WHERE id_usuario = $idUsuario ORDER BY id DESC LIMIT 1";
  $resultado = $conexao->query($query);

  if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    return $row['valor'];
  }

  return 0; 
}

function calcularGastoEletrodomestico($conexao, $potencia, $horas, $quantidade, $tarifa) {
  $consumoDiario = $potencia * $horas * $quantidade;
  $consumoMensal = $consumoDiario * 30;
  $gastoMensal = $consumoMensal * $tarifa;

  return $gastoMensal;
}

$mysqli = new mysqli("powercontrol.c3ihimjgulac.us-east-1.rds.amazonaws.com", "root", "adminpowercontrol", "clientes");

if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
} else {
    $tarifa = obterUltimoValorTarifa($mysqli, $idUsuario);

    $query = "SELECT * FROM eletro WHERE id_usuario = $idUsuario";
    $resultado = $mysqli->query($query);

    $totalGastos = 0;

    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $nome = $row['nome'];
            $consumo = $row['consumo'];
            $horas = $row['horas'];
            $quantidade = $row['quantidade'];

            $gastoEletrodomestico = calcularGastoEletrodomestico($mysqli, $consumo, $horas, $quantidade, $tarifa);

            $totalGastos += $gastoEletrodomestico;

$totalItems = floor($gastoEletrodomestico / 10);
$totalItemsDecimal = $totalItems / 100;
$totalItemsFormatados = number_format($totalItemsDecimal, 2, ',', '');
echo "<li>
        <span class='item-name'>$nome</span>
        <span class='item-usage'>R$" . $totalItemsFormatados . "</span>
      </li>";

        }
    }
            $totalFormatado = floor($totalGastos / 10);
            $valorDecimal = $totalFormatado / 100;
            $valortotal = number_format($valorDecimal, 2, ',', '.');

    echo "<script>var totalValue = 'R$ ' +'$valortotal';</script>";
         
    $mysqli->close();
}
?>
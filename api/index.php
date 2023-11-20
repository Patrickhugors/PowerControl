<?php
$sessionPath = '/tmp';

if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0700, true);
}

ini_set('session.save_path', $sessionPath);

session_start();

if (!isset($_SESSION['contador'])) {
    $_SESSION['contador'] = 1;
} else {
    $_SESSION['contador']++;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Sessão</title>
</head>
<body>

    <h1>Exemplo de Sessão</h1>

    <p>Esta página foi visualizada <?php echo $_SESSION['contador']; ?> vezes.</p>

</body>
</html>

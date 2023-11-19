<?php
session_start();
session_destroy();
header("Location: ../src/html/login.html");
exit;
?>

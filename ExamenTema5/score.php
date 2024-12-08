<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1> Tu puntacion actual es :</h1>
  <ul>
    
  <?php
  foreach ($_SESSION['fecha'] as  $value) {
    printf(' <li>%s: %s respuestas correctas</li>',$value,$_SESSION[$value]);//se que sumo uno porque no logre arreglar cargando 0 respuestas
  }
  ?>
  </ul>
</body>
</html>

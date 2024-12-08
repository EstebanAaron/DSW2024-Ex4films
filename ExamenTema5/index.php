<?php
session_start();
if (isset($_COOKIE['name'])) {
  header('Location: quest.php');
}

if(!(empty($_POST['name']))){
  $name = $_POST['name'];
  setcookie('name',$name , time()+880);
  setcookie($name, 0 , time()+880);
  header('Location: quest.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Bienvenido al juego de las preguntas diarias</h1>
  <form action="" method="post">  
    <p>¿Puedes indicarme tu nombre?</p>
    <input type="text" name="name" id="" placeholder="tu nombre">
    <button type="submit">entrar</button>
  </form>
</body>
</html>
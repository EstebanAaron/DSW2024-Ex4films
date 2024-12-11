<?php
require 'questions.php';
session_start();
if (empty($_COOKIE['name'])) {
  header('Location: index.php');
}


if ((isset($_POST['answer']))) {
  $count= ++$_POST['count'];
  $answer = $_POST['answer'];
  $mensaje='correcto';
}
else{
  $count=0;
  $answer='vacio';
  $mensaje='';
  
}


$error = true;
$continue=true;

if (!isset($_SESSION['fecha'])) { $_SESSION['fecha'] = array();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1><?php echo $_COOKIE['name']; ?> <a href="rmproces.php">Eliminar Usuario</a><a href="score.php">Ver Puntuaciones</a></h1>

  <p>
    <h2>Reto Diario</h2>
  </p>
  <p>
    Fecha : <?php 
    $today = date('d-m-Y'); 
    if (isset($dailyQuestions[$today])) {
      echo $today.'|'.$dailyQuestions[$today]['topic'];
    }else{
      echo '<p>No hay reto para el dia de hoy</p>';
      $error=false;
    }
    
    
    ?>
  </p>

  

  <?php
  if ($error) {
   
  
  if (isset($_SESSION[$today])) {
    if ($count==0) {
      $error=false;
    }
    
  }else{
    $_SESSION[$today]=0;
  }
  if($mensaje==''){ 
  }else{
  if ($answer==$dailyQuestions[$today]['questions'][$count-1]['correct']) {
    echo 'Correcto<br>';
    
      if (in_array($today,$_SESSION['fecha'])) {
        
      }
      else{
        $_SESSION['fecha'][]= $today;

      }
      $_SESSION[$today]++;
    

  }else{
    echo 'ERROR<br>';
    $continue=false;

    if (in_array($today,$_SESSION['fecha'])) {
        
    }
    else{
      $_SESSION['fecha'][]= $today;

    }
  }
}
print_r($_SESSION['fecha']);
  if (count($dailyQuestions[$today]['questions'])>$count&&$continue) {

    if (!$error) {
      echo 'Ya hicistes tus preguntas diarias';
    }
    else{

    echo $dailyQuestions[$today]['questions'][$count]['statement'];

    
    echo '<form action="" method="post">';
    foreach ($dailyQuestions[$today]['questions'][$count]['answers'] as $key => $value) {
     printf('<label for="%s">%s</label><input type="radio" name="answer" id="%s" value="%s"> %s<br>',$key,$key,$key,$key,$value);
    }
    echo '<button type="submit">Enviar</button>';
  }
  }
  else{
      echo 'Terminaste las preguntas con '.($count-1).' respuestas correctas'.$count;
  }
}

  ?>
  
   <input type="number" name="count" value="<?php echo $count;?>" hidden>
  </form>
</body>
</html>
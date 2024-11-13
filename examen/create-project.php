<?php require 'connection.php'; ?>
<?php require 'menu.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Proyecto</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Crear un proyecto</h1>
<?php 
  if (isset($_POST['name']) ||isset($_POST['hours'])) {
    $nameProject =$_POST['name']??null;
    $hoursProject =$_POST['hours']??null;

   

    if (is_numeric($hoursProject)&&!($nameProject==null)) {
      
      $stmtInsert = $conn->prepare("INSERT INTO `projects`( `name`, `max_hours`) VALUES (:name,:hours)");
     $stmtInsert->bindParam(':name',$nameProject);
     $stmtInsert->bindParam(':hours',$hoursProject);
     $stmtInsert->execute();
     echo '<div class="success"><h2>Proyecto creado con éxito</h2></div>';
    }
    else{
      echo '<div class="error"><h2>Error al crear el proyecto</h2><p>Datos mal introducidos<p></div>';
    }

     
  }
  else{

  
?>
  <form action="create-project.php" method="post">
    <fieldset>
      <legend>Nuevo proyecto</legend>
      <p>
        <label for="">Nombre: </label>
        <input type="text" name="name">
      </p>
      <p>
        <label for="">Horas máximo:</label>
        <input type="number" name="hours">
      </p>
      <p>
        <button type="submit" name="create">Crear</button>
      </p>
    </fieldset>
  </form>
  
  <?php
  $stmtInsert=null;
  $conn=null;
  }
  ?>
</body>
</html>
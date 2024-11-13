<?php require 'connection.php'; ?>
<?php require 'menu.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  if (isset($_POST['employee_id'])&&isset($_POST['hours'])&&($_POST['hours'])>0) {
    $idEmployee=$_POST['employee_id'];
    $hours=$_POST['hours'];
    $idProject =$_POST['name'];
    
    
    try {
      $conn->beginTransaction();
      
    $stmtAssigments = $conn->prepare('SELECT `name`, `role`,`assigned_hours` FROM `employees` INNER JOIN assignments ON employees.employee_id= assignments.employee_id WHERE assignments.project_id =:id');
    $stmtAssigments->bindParam(':id',$idProject,PDO::PARAM_INT);
    $stmtAssigments->execute();
    $assigments= $stmtAssigments->fetchAll(PDO::FETCH_OBJ);
    $stmtHoursMax = $conn->prepare('SELECT name,max_hours,project_id from projects where project_id=:id');
    $stmtHoursMax->bindParam(':id',$idProject,PDO::PARAM_INT);
    $stmtHoursMax->execute();
    $project= $stmtHoursMax->fetch(PDO::FETCH_OBJ);


    $stmtInsertEmployee= $conn->prepare("INSERT INTO `assignments`( `project_id`, `employee_id`, `assigned_hours`) VALUES (:idProject,:idEmployee,:hours)");
    $stmtInsertEmployee->bindParam(':idProject',$project->project_id,PDO::PARAM_INT);
    $stmtInsertEmployee->bindParam(':idEmployee',$idEmployee,PDO::PARAM_INT);
    $stmtInsertEmployee->bindParam(':hours',$hours,PDO::PARAM_INT);
    $stmtInsertEmployee->execute();

    $totalHours=0;
    if (empty($assigments)) {  
    }
    else{
      
      foreach ($assigments as $assigment) {
        
        $totalHours +=$assigment->assigned_hours;
      }
    }

    if (($totalHours+$hours)>($project->max_hours)) {
      echo '<div class="error"><h2>Error al Insertar al empleado</h2><p>Se excede el tiempo maximo<p></div>';
      $conn->rollBack();
    }else{
      
      $conn->commit();
      echo '<div class="success">Se pudo insertar sin problemas</div>';
    }
    

    }catch(Exception $e){
      echo $e->getMessage();
      }
  }else{
    echo '<div class="error"><h2>Error al Insertar al empleado</h2><p>Datos mal introducidos<p></div>';
  }
  ?>
  
</body>
</html>
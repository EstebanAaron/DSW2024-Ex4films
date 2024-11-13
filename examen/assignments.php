<?php require 'connection.php'; ?>
<?php require 'menu.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asignaciones</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
  if (isset($_GET['name'])) {
    $idProject = $_GET['name'];
    $stmtAssigments = $conn->prepare('SELECT `name`, `role`,`assigned_hours` FROM `employees` INNER JOIN assignments ON employees.employee_id= assignments.employee_id WHERE assignments.project_id =:id');
    $stmtAssigments->bindParam(':id',$idProject,PDO::PARAM_INT);
    $stmtAssigments->execute();
    $assigments= $stmtAssigments->fetchAll(PDO::FETCH_OBJ);
    $stmtHoursMax = $conn->prepare('SELECT name,max_hours from projects where project_id=:id');
    $stmtHoursMax->bindParam(':id',$idProject,PDO::PARAM_INT);
    $stmtHoursMax->execute();
    $project= $stmtHoursMax->fetch(PDO::FETCH_OBJ);
    
  }
 
  ?>
<h1>Asignaciones al proyecto</h1>
  <table>
    <thead>
      <tr>
        <th colspan="3"><?php echo $project->name; ?></th>
      </tr>
      <tr>
        <td colspan="3">Horas máximo: <strong><?php echo $project->max_hours; ?> </strong></td>
      </tr>
      <tr>
        <th>Empleado</th>
        <th>Horas</th>
        <th>Cargo</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $totalHours=0;
      if (empty($assigments)) {
        printf('<tr><td colspan="3">No hay empleados asignados a este proyecto</td></tr>');
      }
      else{
        
        foreach ($assigments as $assigment) {
          printf('<tr><td>%s</td><td>%d</td><td>%s</td></tr>',
          $assigment->name,$assigment->assigned_hours,$assigment->role);
          $totalHours +=$assigment->assigned_hours;
        }
      }
      ?>
      
    </tbody>
    <tfoot>
      <tr>
        <th>Horas asignadas:</th>
        <td><?php echo $totalHours;  ?></td>
        <td></td>
      </tr>
      <tr>
        <form action="proccesInsert.php" method="post">
          <td>
            <select name="employee_id">
              <option disabled selected>Elige un empleado...</option>
<?php
  $stmtEmpleoyees=$conn->prepare('SELECT `employee_id`, `name` FROM `employees`');
  $stmtEmpleoyees->execute();
  $empleoyees= $stmtEmpleoyees->fetchAll(PDO::FETCH_OBJ);
  foreach ($empleoyees as $value) {
    printf('<option value="%d">%s</option>',
  $value->employee_id,$value->name);
  }
?>
              
            </select>
          </td>
          <td>
            <input type="number" name="hours" value="0" min="0" max="3">
          </td>
          <td>
            <button type="submit">Asignar</button>
            <input type="hidden" name="name" value="<?php echo $idProject; ?>">
            
          </td>
        </form>
      </tr>
    </tfoot>
  </table>
</body>
</html>
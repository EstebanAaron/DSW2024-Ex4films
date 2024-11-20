<?php session_start();
?>
<?php require 'connection.php'; ?>
<?php require 'menu.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyectos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Proyectos</h1>

  <table>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Horas máx.</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stmtProjects = $conn->prepare('SELECT `project_id`, `name`, `max_hours` FROM `projects`');
      $stmtProjects->execute();
      $projects = $stmtProjects->fetchAll(PDO::FETCH_OBJ);
      $totalHours=0;
      foreach ($projects as $project) {
        printf('      <tr><td><a href="assignments.php?name=%d">%s</a></td><td>%d</td><td><a href="processDelete.php?id=%s">Eliminar</a></td></tr>',
        $project->project_id,$project->name,$project->max_hours,$project->project_id);
        $totalHours +=$project->max_hours;
      }
      $stmtProjects=null;
      $conn=null;
      ?>
    </tbody>
    <tfoot>
      <th>Horas totales</th>
      <td><?php echo $totalHours; ?></td>
      <td></td>
    </tfoot>
  </table>
</body>
</html>
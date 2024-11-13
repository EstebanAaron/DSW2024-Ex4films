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
  <!-- <div class="success">Se pudo borrar sin problemas</div>
  <div class="error">Error no se pudo borrar</div> -->
  
</body>
</html>

<?php
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmtCheck=$conn->prepare('SELECT `project_id`, `name`, `max_hours` FROM `projects`');
      $stmtCheck->execute();
      $idChecks = $stmtCheck->fetchAll(PDO::FETCH_ASSOC);

      $idChecksArray =array_column($idChecks,'project_id');
      
      if (!in_array($id,$idChecksArray)) {
        echo '<div class="error"><h1>Error no existe esa id</h1></div>';
      }
      else{
        $stmtDelete=$conn->prepare('DELETE FROM projects where project_id=:id');
    $stmtDelete->bindParam(':id',$id,pdo::PARAM_INT);
    try {
      $stmtDelete->execute();
      echo '<div class="success">Se pudo borrar sin problemas</div>';

    } catch (PDOException $e) {
      echo '<div class="error"><h1>Error no se pudo borrar</h1> '.$e->getMessage(). '</div>';
    }
      }

      $stmtCheck=null;
      $conn=null;
    
    
  }
?>
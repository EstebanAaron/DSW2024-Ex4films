<?php include "top.php"; ?>
<?php require 'connection.php'; ?>
<section id="create">
    <h2>Nueva categoría</h2>
    <nav>
        <p><a href="film.php">Volver</a></p>
    </nav>
    
    <?php
    if (isset($_GET['name'])) {
    $name = $_GET['name'];

    $stmtCreate =  $conn->prepare('INSERT INTO category (category_id, name, last_update) VALUES (NULL,:Categoryname ,CURRENT_TIMESTAMP)');
    $stmtCreate->bindParam(':Categoryname',$name);

    try {
        $stmtCreate->execute();
        echo '<p class="alert alert-success">Se creo una nueva categoria</p>';
    } catch (Exception $e) {
        echo 'no funciono';
    }
    }else{

    
    ?>
    <form action="" autocomplete="off">
        <fieldset>
            <legend>Datos de la categoría</legend>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" required>
            <p></p>
            <input type="reset" value="Limpiar">            
            <input type="submit" value="Crear">
        </fieldset>
    </form>
    <?php } ?>
</section>
<?php include "bottom.php"; ?>
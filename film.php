<?php include "top.php"; ?>
<?php require 'connection.php'; ?>
    <!--
    <div class="alert alert-success">¡Ejemplo mensaje de éxito!</div>
    <div class="alert alert-error">¡Ejemplo mensaje de error!</div>
    -->
    <section id="films">
        <h2>Peliculas</h2>
        
<?php
        if (isset($_GET['delete'])&&(!empty($_GET['category']))) {
            
            $stmtDelete = $conn->prepare('DELETE FROM category where category_id = :category_id');
            $stmtDelete->bindParam(':category_id',$_GET['category']);
            try {
                $stmtDelete->execute();
                echo '<p class="alert alert-success">Se borró la categoria</p>';
            } catch (\Throwable $th) {
                echo '<p class="alert alert-error">Hay peliculas con esa categoria</p>';
            }
        }



    try {
        if (isset($_GET['search'])&&(!empty($_GET['category']))) {
            

            $category= $_GET['category'];
            $stmtFilms = $conn->prepare('SELECT `title`, `release_year`, `length` FROM `film` INNER JOIN `film_category` ON `film`.`film_id` = `film_category`.`film_id` WHERE `film_category`.`category_id` = :category');
            $stmtFilms->bindParam(':category',$category, PDO::PARAM_INT);
            $stmtFilms->execute();
            $films = $stmtFilms->fetchAll(PDO::FETCH_OBJ);
            

        }


        $stmtCategories = $conn->prepare('SELECT category_id, name FROM category');
        $stmtCategories->execute();
        $categories = $stmtCategories->fetchAll(PDO::FETCH_OBJ);

?>
        <form action="film.php" method="get">
          <fieldset>
            <legend>Categorías</legend>
            <select name="category" id="">
              <option selected disabled>Elige una categoría</option>
<?php
        foreach($categories as $category) {
            printf('<option value="%d">%s</option>',$category->category_id, $category->name);
        }
?>
            </select>
            <input type="submit" name="search" value="buscar">
            <input type="submit" name="delete" value="eliminar">
          </fieldset>
        </form>
<?php
        $stmtCategories = null;
    } catch (Exception $e) {
        die('<p>Se jodio: ' . $e->getMessage() . '</p>');
    }
    
    $conn = null; 
?>
        <nav>
            <fieldset>
                <legend>Acciones</legend>                    
                <a href="create.php">
                    <button>Crear Categoria</button>
                </a>                    
            </fieldset>
        </nav>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Año</th>
                    <th>Duración</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                

<?php
if (isset($films)) {
    foreach ($films as $film) {
        printf('<tr><td>%s</td><td class="center">%d</td><td class="center">%d</td><td class="actions"><a class="button" href="category_film.php?name=%s"><button>Cambiar categorías</button></a></td></tr>',
        $film->title , $film->release_year, $film->length, $film->title);
    }
}
    

?>
                    
            </tbody>
        </table>
    </section>
    <?php 
    if (isset($films)&&count($films)==0) {
        echo '<p class="alert alert-error">No hay peliculas con esa categoria</p>';
    }
    ?>
<?php include "bottom.php"; ?>
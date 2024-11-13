<?php include "top.php"; ?>
<?php require 'connection.php'; ?>

<nav>
    <p><a href="film.php">Volver</a></p>
</nav>

<?php
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
    }
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    }
?>

<section id="films">
    <h2>Categorías de la película: <?php echo $name; ?></h2>

    <?php
    if (isset($_POST['categories'])|| isset($_POST['name'])) {
        try {
            $conn->beginTransaction();

            $CategoriesCheckeds = $_POST['categories']??null;
            

            // Obtener el film_id para la película
            $stmtFilm = $conn->prepare('SELECT film_id FROM film WHERE title = :title');
            $stmtFilm->bindParam(':title', $name);
            $stmtFilm->execute();
            $idFilm = $stmtFilm->fetchColumn();

            // Obtener las categorías actuales asociadas con esta película
            $stmtChecked = $conn->prepare('SELECT category_id FROM film_category WHERE film_id = :film_id');
            $stmtChecked->bindParam(':film_id', $idFilm);
            $stmtChecked->execute();
            $checkedsOBJ = $stmtChecked->fetchAll(PDO::FETCH_OBJ);
            $checkeds = array_map(function($check) {
                return $check->category_id;
            }, $checkedsOBJ);

           


            if (empty($CategoriesCheckeds)) {
              $stmtRemoveAll = $conn->prepare('DELETE FROM film_category WHERE film_id = :idFilm');
              $stmtRemoveAll->bindParam(':idFilm', $idFilm);
              $stmtRemoveAll->execute();
          } else {
              // Comparar las categorías para añadir o eliminar
              $categoriesToRemove = array_diff($checkeds, $CategoriesCheckeds);
              $categoriesToAdd = array_diff($CategoriesCheckeds, $checkeds);

              // Eliminar las categorías que ya no están seleccionadas
              foreach ($categoriesToRemove as $value) {
                  $stmtRemove = $conn->prepare('DELETE FROM film_category WHERE film_id = :idFilm AND category_id = :category_id');
                  $stmtRemove->bindParam(':idFilm', $idFilm);
                  $stmtRemove->bindParam(':category_id', $value);
                  $stmtRemove->execute();
              }

              // Añadir las nuevas categorías seleccionadas
              foreach ($categoriesToAdd as $value) {
                  $stmtUpdate = $conn->prepare('INSERT INTO film_category (film_id, category_id, last_update) VALUES (:idFilm, :idCategory, CURRENT_TIMESTAMP)');
                  $stmtUpdate->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);
                  $stmtUpdate->bindParam(':idCategory', $value, PDO::PARAM_INT);
                  $stmtUpdate->execute();
              }
          }


            // Confirmar transacción
            $conn->commit();
            echo '<div class="alert alert-success">¡Actualización exitosa!</div>';

        } catch (PDOException $e) {
            $conn->rollBack();
            echo '<div class="alert alert-error">¡Error al actualizar!</div>' . $e->getMessage();
        }
    }
    ?>

    <form action="category_film.php" method="post">
        <ul>
            <?php
            try {
                // Obtener las categorías disponibles
                $stmtCategories = $conn->prepare('SELECT category_id, name FROM category');
                $stmtCategories->execute();
                $categories = $stmtCategories->fetchAll(PDO::FETCH_OBJ);

                // Obtener las categorías actualmente asociadas a la película
                $stmtChecked = $conn->prepare('SELECT category_id FROM film_category WHERE film_id = (SELECT film_id FROM film WHERE title = :title)');
                $stmtChecked->bindParam(':title', $name);
                $stmtChecked->execute();
                $checkedsOBJ = $stmtChecked->fetchAll(PDO::FETCH_OBJ);
                $checkeds = array_map(function($check) {
                    return $check->category_id;
                }, $checkedsOBJ);

                // Mostrar los checkboxes con las categorías
                foreach ($categories as $value) {
                    $checked = in_array($value->category_id, $checkeds) ? 'checked' : '';
                    printf('<li><label><input type="checkbox" name="categories[]" value="%s" %s>%s</label></li>',
                        $value->category_id, $checked, $value->name);
                }
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            ?>
        </ul>
        <p>
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="submit" value="Actualizar">
        </p>
    </form>
</section>

<?php include "bottom.php"; ?>

<?php
if(isset($_GET['id_matiere'])){
    $id_matiere = $_GET['id_matiere'];
    $sql = "SELECT * FROM matiere WHERE id_matiere=$id_matiere";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <br><br><br>
    <form method="post" action="">
        <input type="hidden" name="id_matiere" value="<?php echo $row['id_matiere']; ?>">
        <label>Nom de la matière:</label> <input type="text" name="nom_matiere" value="<?php echo $row['nom_matiere']; ?>" required><br>
        <label>Coefficient:</label> <input type="number" name="coef" value="<?php echo $row['coef']; ?>" required><br>
        <input type="submit" name="modifier" value="Modifier">
    </form>
    <?php
}

if(isset($_POST['modifier'])){
    $id_matiere = $_POST['id_matiere'];
    $nom_matiere = $_POST['nom_matiere'];
    $coef = $_POST['coef'];

    $sql = "UPDATE matiere SET nom_matiere='$nom_matiere', coef='$coef' WHERE id_matiere=$id_matiere";
    if(mysqli_query($connexion, $sql)){
        echo "Matière modifiée avec succès.";
        header("Location: index.php?pages=2"); 
    } else {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($connexion);
    }
}?>
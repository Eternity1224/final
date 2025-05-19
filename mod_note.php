<!DOCTYPE html>
<html>
<head>
    <title>Modification des Notes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h3>Modification des Notes</h3>
<?php
include_once('connexion.php');
if (isset($_GET['id_note'])) {
    $id_note = $_GET['id_note'];
    $sql = "SELECT * FROM note WHERE id_note=$id_note";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <form method="post" action="">
        <input type="hidden" name="id_note" value="<?php echo $row['id_note']; ?>">
        <label>Matricule de l'étudiant:</label>
        <select name="mat_etu" required>
            <?php
            $sql_etu = "SELECT Matricule FROM etudiant";
            $result_etu = mysqli_query($connexion, $sql_etu);
            if (mysqli_num_rows($result_etu) > 0) {
                while ($row_etu = mysqli_fetch_assoc($result_etu)) {
                    $selected = ($row['mat_etu'] == $row_etu['Matricule']) ? "selected" : "";
                    echo "<option value='" . $row_etu["Matricule"] . "' $selected>" . $row_etu["Matricule"] . "</option>";
                }
            } else {
                echo "<option value=''>Aucun étudiant trouvé</option>";
            }
            ?>
        </select><br>
        <label>Matière:</label>
        <select name="id_matiere" required>
            <?php
            $sql_matiere = "SELECT id_matiere, nom_matiere FROM matiere";
            $result_matiere = mysqli_query($connexion, $sql_matiere);
            if (mysqli_num_rows($result_matiere) > 0) {
                while ($row_matiere = mysqli_fetch_assoc($result_matiere)) {
                    $selected = ($row['id_matiere'] == $row_matiere['id_matiere']) ? "selected" : "";
                    echo "<option value='" . $row_matiere["id_matiere"] . "' $selected>" . $row_matiere["nom_matiere"] . "</option>";
                }
            } else {
                echo "<option value=''>Aucune matière trouvée</option>";
            }
            ?>
        </select><br>
        <label>Valeur de la note:</label> <input type="number" name="valeur_note" min="0" max="20" step="0.01" value="<?php echo $row['valeur_note']; ?>" required><br>
        <input type="submit" name="modifier" value="Modifier">
    </form>
    <?php
}

if (isset($_POST['modifier'])) {
    $id_note = $_POST['id_note'];
    $mat_etu = $_POST['mat_etu'];
    $id_matiere = $_POST['id_matiere'];
    $valeur_note = $_POST['valeur_note'];

    $sql = "UPDATE note SET mat_etu=?, id_matiere=?, valeur_note=? WHERE id_note=?";
    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "sidi", $mat_etu, $id_matiere, $valeur_note, $id_note);

    if (mysqli_stmt_execute($stmt)) {
        echo "Note modifiée avec succès.";
        header("Location: index.php?pages=3"); 
        exit();
    } else {
        echo "Erreur: " . mysqli_error($connexion);
    }
    mysqli_stmt_close($stmt);
}
?>
</body>
</html>
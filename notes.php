<form method="post" action="">
    <label>Matricule de l'étudiant:</label>
    <select name="mat_etu" required>
        <?php
        $result_etu = mysqli_query($connexion, "SELECT Matricule FROM etudiant");
        while ($row_etu = mysqli_fetch_assoc($result_etu)) {
            echo "<option value='".$row_etu['Matricule']."' >" . $row_etu["Matricule"] . "</option>";
        }
        ?>
    </select><br>

    <label>Matière:</label>
    <select name="id_matiere" required>
        <?php
        $result_matiere = mysqli_query($connexion, "SELECT id_matiere, nom_matiere FROM matiere");
        while ($row_matiere = mysqli_fetch_assoc($result_matiere)) {
            echo "<option value='" . $row_matiere["id_matiere"] . "'>" . $row_matiere["nom_matiere"] . "</option>";
        }
        ?>
    </select><br>

    <label>Valeur de la note:</label>
    <input type="number" name="valeur_note" min="0" max="20" step="0.01" required><br>
    <input type="submit" name="ajouter" value="Ajouter">
</form>

<?php
if (isset($_POST['ajouter'])) {
    $stmt = mysqli_prepare($connexion, "INSERT INTO note (mat_etu, id_matiere, valeur_note) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sid", $_POST['mat_etu'], $_POST['id_matiere'], $_POST['valeur_note']);
    echo mysqli_stmt_execute($stmt) ? "<p style='color:green;'>Note ajoutée avec succès.</p>" : "<p style='color:red;'>Erreur.</p>";
    mysqli_stmt_close($stmt);
}
if(isset($_GET['supprimer_note'])){
    $val = $_GET['supprimer_note'];
    $requette = "DELETE FROM note WHERE id_note=$val";
    $sup = mysqli_query($connexion,$requette);
    header("Location: index.php?pages=3");
    exit();
}
?>

<table>
    <thead>
        <tr>
            <th>Matricule</th><th>Nom</th><th>Matière</th><th>Note</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($connexion, "SELECT note.id_note, note.mat_etu, etudiant.Nom, etudiant.Prenom, matiere.nom_matiere, note.valeur_note FROM note
                INNER JOIN etudiant ON note.mat_etu = etudiant.Matricule
                INNER JOIN matiere ON note.id_matiere = matiere.id_matiere");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row["mat_etu"]}</td>
                    <td>{$row["Nom"]} {$row["Prenom"]}</td>
                    <td>{$row["nom_matiere"]}</td>
                    <td>" . number_format($row["valeur_note"], 2, ',', ' ') . "</td>
                    <td>
                        <a href='index.php?pages=7&id_note={$row["id_note"]}'>Modifier</a> | 
                        <a href='#' onclick='confirmerSuppression({$row["id_note"]})'>Supprimer</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Code pour la modification des notes
if(isset($_GET['modifier_note'])) {
    $id_note = $_GET['modifier_note'];
    $sql = "SELECT note.*, etudiant.Nom, etudiant.Prenom, matiere.nom_matiere 
            FROM note 
            INNER JOIN etudiant ON note.mat_etu = etudiant.Matricule 
            INNER JOIN matiere ON note.id_matiere = matiere.id_matiere 
            WHERE note.id_note = $id_note";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <h3>Modifier la note</h3>
    <form method="post" action="">
        <input type="hidden" name="id_note" value="<?php echo $id_note; ?>">
        <label>Étudiant:</label>
        <input type="text" value="<?php echo $row['Nom'] . ' ' . $row['Prenom']; ?>" readonly><br>
        <label>Matière:</label>
        <input type="text" value="<?php echo $row['nom_matiere']; ?>" readonly><br>
        <label>Nouvelle note:</label>
        <input type="number" name="valeur_note" min="0" max="20" step="0.01" value="<?php echo $row['valeur_note']; ?>" required><br>
        <input type="submit" name="modifier" value="Modifier">
    </form>
    <?php
}

if(isset($_POST['modifier'])) {
    $id_note = $_POST['id_note'];
    $valeur_note = $_POST['valeur_note'];
    
    $sql = "UPDATE note SET valeur_note = ? WHERE id_note = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "di", $valeur_note, $id_note);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<p style='color:green;'>Note modifiée avec succès.</p>";
        header("Location: index.php?pages=3");
        exit();
    } else {
        echo "<p style='color:red;'>Erreur lors de la modification.</p>";
    }
    mysqli_stmt_close($stmt);
}
?>

<script>
        function confirmerSuppression(id_note) {
            if (confirm("Êtes-vous certain(e) de vouloir supprimer cette note ?")) {
            window.location.href = "index.php?pages=3&supprimer_note=" + encodeURIComponent(id_note);
        }
        }
</script>
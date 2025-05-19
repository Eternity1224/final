<h3>Ajouter une matière</h3>
<form method="post" action="">
    <label>Nom de la matière:</label> <input type="text" name="nom_matiere" required><br>
    <label>Coefficient:</label> <input type="number" name="coef" required><br>
    <input type="submit" name="ajouter" value="Ajouter">
</form>

<?php
if (isset($_POST['ajouter'])) {
    $nom_matiere = mysqli_real_escape_string($connexion, $_POST['nom_matiere']);
    $coef = intval($_POST['coef']);

    $res = mysqli_query($connexion, "SELECT * FROM matiere WHERE nom_matiere = '$nom_matiere'");
    echo mysqli_num_rows($res) > 0 ? "<p style='color:red;'>Cette matière existe déjà !</p>" : (
        mysqli_query($connexion, "INSERT INTO matiere (nom_matiere, coef) VALUES ('$nom_matiere', '$coef')") ? 
        "<strong style='color:green;'>Matière ajoutée avec succès.</strong>" : 
        "<p style='color:red;'>Erreur.</p>"
    );
}
?>

<table>
    <thead>
        <tr>
            <th>Nom de la matière</th><th>Coefficient</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($connexion, "SELECT * FROM matiere");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row["nom_matiere"]}</td>
                    <td>{$row["coef"]}</td>
                    <td>
                        <a  href='index.php?pages=5&id_matiere=".$row["id_matiere"]."'>Modifier</a> |
                        <a href='#' onclick='confirmerSuppression(".$row["id_matiere"].")'>Supprimer</a>
                    </td>
                  </tr>";
        }
        ?>
     

    </tbody>
</table>

<?php

if(isset($_POST['modifier']))
{
    echo mysqli_query($connexion, "UPDATE matiere SET nom_matiere='{$_POST['nom_matiere']}', coef='{$_POST['coef']}' WHERE id_matiere={$_POST['id_matiere']}") ? 
         "Matière modifiée avec succès." : 
         "<p style='color:red;'>Erreur.</p>";
    header("Location: index.php?pages=2");
}

if(isset($_GET['supprimer_matiere'])){
        $val = $_GET['supprimer_matiere'];
        $requette = "DELETE FROM matiere WHERE id_matiere=$val";
        $sup = mysqli_query($connexion,$requette);
        header("Location: index.php?pages=2");
}
?>
   <script>
        function confirmerSuppression(id_matiere) {
            if (confirm("Êtes-vous certain(e) de vouloir supprimer cet étudiant ?")) {
            window.location.href = "index.php?pages=2&supprimer_matiere=" + encodeURIComponent(id_matiere);
        }
        }
</script>
 

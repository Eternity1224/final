<h3>Ajouter un étudiant</h3>
<form method="post" action="">
    <label>Nom:</label> <input type="text" name="nom" required><br>
    <label>Prénom:</label> <input type="text" name="prenom" required><br>
    <label>Matricule:</label> <input type="text" name="matricule" required><br>
    <label>Filière:</label> <input type="text" name="filiere" required><br>
    <label>Classe:</label> <input type="text" name="classe" required><br>
    <input type="submit" name="ok" value="Ajouter">
</form>
<?php
if (isset($_POST['ok'])) {
    $matricule = mysqli_real_escape_string($connexion, $_POST['matricule']);
    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $filiere = mysqli_real_escape_string($connexion, $_POST['filiere']);
    $classe = mysqli_real_escape_string($connexion, $_POST['classe']);

    
    $check = "SELECT * FROM etudiant WHERE matricule = '$matricule'";
    $res = mysqli_query($connexion, $check);

    if (mysqli_num_rows($res) > 0) {
        
        echo "<p> Ce matricule existe déjà !</p>";
    } else {
        
        $sql = "INSERT INTO etudiant (matricule, nom, prenom, filiere, classe)
                VALUES ('$matricule', '$nom', '$prenom', '$filiere', '$classe')";
        
        if (mysqli_query($connexion, $sql)) {
            echo "<p>Étudiant ajouté avec succès.</p>";
        } else {
            echo "<p>Erreur : " . mysqli_error($connexion) . "</p>";
        }
    }
}
?>

<h3>Liste des étudiants</h3>
<table >
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Matricule</th>
            <th>Filière</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM etudiant";
        $result = mysqli_query($connexion, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["Nom"]. "</td>";
                echo "<td>" . $row["Prenom"]. "</td>";
                echo "<td>" . $row["Matricule"]. "</td>";
                echo "<td>" . $row["Filiere"]. "</td>";
                echo "<td>" . $row["Classe"]. "</td>";
                echo "<td>
                           <a href='index.php?pages=6&id_etu=".$row["id_etu"]."'>Modifier</a> |
                           <a href='#' onclick='confirmerSuppression(".$row["id_etu"].")'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'><strong>Aucun étudiant trouvé<strong></td></tr>";
        }
        ?>
    </tbody>
</table>
<br><br><br>
<?php
if(isset($_GET['modifier_etu'])){
    $id_etu = $_GET['modifier_etu'];
    $sql = "SELECT * FROM etudiant WHERE id_etu=$id_etu";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <h3>Modifier l'étudiant</h3>
    <form method="post" action="">
        <input type="hidden" name="id_etu" value="<?php echo $row['id_etu']; ?>">
        <label>Nom:</label> <input type="text" name="Nom" value="<?php echo $row['Nom']; ?>" required><br>
        <label>Prénom:</label> <input type="text" name="Prenom" value="<?php echo $row['Prenom']; ?>" required><br>
        <label>Matricule:</label> <input type="text" name="Matricule" value="<?php echo $row['Matricule']; ?>" required><br>
        <label>Filière:</label> <input type="text" name="Filiere" value="<?php echo $row['Filiere']; ?>" required><br>
        <label>Classe:</label> <input type="text" name="Classe" value="<?php echo $row['Classe']; ?>" required><br>
        <input type="submit" name="modifier" value="Modifier">
    </form>
    <?php
}

if(isset($_POST['modifier'])){
    $id_etu = $_POST['id_etu'];
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Matricule = $_POST['Matricule'];
    $Filiere = $_POST['Filiere'];
    $Classe = $_POST['Classe'];

    $sql = "UPDATE etudiant SET Nom='$Nom', Prenom='$Prenom', Matricule='$Matricule', Filiere='$Filiere', Classe='$Classe' WHERE id_etu=$id_etu";
    if(mysqli_query($connexion, $sql)){
        echo "<strong>Étudiant modifié avec succès.</strong>";
        header("Location: index.php?pages=1"); 
    } else {
        echo "Erreur: " . $sql . "<br>" . mysqli_error($connexion);
    }
}
if (isset($_GET['supprimer_etu'])) {
    $id_etu = intval($_GET['supprimer_etu']);
    $sqli = "DELETE FROM etudiant WHERE id_etu= $id_etu";

    if (isset($connexion)) {
        $resultr = mysqli_query($connexion, $sqli);

        if ($resultr) {
            header("Location: index.php?pages=1");
            exit();
        } else {
            echo "Erreur lors de la suppression : " . mysqli_error($connexion);
        }
    } else {
        echo "Erreur de connexion à la base de données.";
    }
}
?>
<script>
function confirmerSuppression(id_etu) {
    if (confirm("Êtes-vous certain(e) de vouloir supprimer cet étudiant ?")) {
        window.location.href = "index.php?pages=1&supprimer_etu=" + encodeURIComponent(id_etu);
    }
}
</script>

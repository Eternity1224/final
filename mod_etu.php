<?php
if (isset($_GET['id_etu'])) {
    $id_etu = $_GET['id_etu'];
    $sql = "SELECT * FROM etudiant WHERE id_etu=$id_etu";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
}
if (isset($_POST['modifier'])) {
    $id_etu = $_POST['id_etu'];
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Matricule = $_POST['Matricule'];
    $Filiere = $_POST['Filiere'];
    $Classe = $_POST['Classe'];
    $sql = "UPDATE etudiant SET 
        Nom='$Nom', 
        Prenom='$Prenom', 
        Matricule='$Matricule', 
        Filiere='$Filiere', 
        Classe='$Classe' 
        WHERE id_etu=$id_etu";

    if (mysqli_query($connexion, $sql)) {
        header("Location: index.php?pages=1");
        exit;
    } else {
        echo "Erreur: " . mysqli_error($connexion);
    }
}
?>

<br><br><br>
<form method="post" action="">
    <input type="hidden" name="id_etu" value="<?php echo $row['id_etu']; ?>">
    <label>Nom:</label> <input type="text" name="Nom" value="<?php echo $row['Nom']; ?>" required><br>
    <label>Prénom:</label> <input type="text" name="Prenom" value="<?php echo $row['Prenom']; ?>" required><br>
    <label>Matricule:</label> <input type="text" name="Matricule" value="<?php echo $row['Matricule']; ?>" required><br>
    <label>Filière:</label> <input type="text" name="Filiere" value="<?php echo $row['Filiere']; ?>" required><br>
    <label>Classe:</label> <input type="text" name="Classe" value="<?php echo $row['Classe']; ?>" required><br>
    <input type="submit" name="modifier" value="Enregistrer les modifications">
</form>
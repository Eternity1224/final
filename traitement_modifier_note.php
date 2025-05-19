<?php
include 'connexion.php';

if(isset($_POST['id_note']) && isset($_POST['valeur_note'])) {
    $id_note = $_POST['id_note'];
    $valeur_note = $_POST['valeur_note'];
    
    $sql = "UPDATE note SET valeur_note = ? WHERE id_note = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "di", $valeur_note, $id_note);
    
    if(mysqli_stmt_execute($stmt)) {
        header("Location: index.php?pages=3&success=1");
    } else {
        header("Location: index.php?pages=3&error=1");
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location: index.php?pages=3");
}
exit();
?> 
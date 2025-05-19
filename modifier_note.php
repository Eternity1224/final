<?php
include 'connexion.php';

if(isset($_GET['id_note'])) {
    $id_note = $_GET['id_note'];
    $sql = "SELECT note.*, etudiant.Nom, etudiant.Prenom, matiere.nom_matiere 
            FROM note 
            INNER JOIN etudiant ON note.mat_etu = etudiant.Matricule 
            INNER JOIN matiere ON note.id_matiere = matiere.id_matiere 
            WHERE note.id_note = $id_note";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Modifier une note</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .form-container {
                max-width: 500px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }
            input[type="text"], input[type="number"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .btn {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .btn:hover {
                background-color: #45a049;
            }
            .btn-cancel {
                background-color: #f44336;
                margin-left: 10px;
            }
            .btn-cancel:hover {
                background-color: #da190b;
            }
        </style>
    </head>
    <body>
        <div class="form-container">
            <h2>Modifier la note</h2>
            <form method="post" action="traitement_modifier_note.php">
                <input type="hidden" name="id_note" value="<?php echo $id_note; ?>">
                
                <div class="form-group">
                    <label>Étudiant:</label>
                    <input type="text" value="<?php echo $row['Nom'] . ' ' . $row['Prenom']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Matière:</label>
                    <input type="text" value="<?php echo $row['nom_matiere']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Nouvelle note:</label>
                    <input type="number" name="valeur_note" min="0" max="20" step="0.01" value="<?php echo $row['valeur_note']; ?>" required>
                </div>

                <button type="submit" class="btn">Enregistrer</button>
                <a href="index.php?pages=3" class="btn btn-cancel">Annuler</a>
            </form>
        </div>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php?pages=3");
    exit();
}
?> 
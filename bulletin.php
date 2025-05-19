<?php
if(isset($_REQUEST['matricule']) && !empty($_REQUEST['matricule'])){
    $matricule = $_REQUEST['matricule'];
    $requete_etudiant = "SELECT nom, prenom, classe, Matricule ,filiere, Domaine FROM etudiant WHERE matricule = '$matricule'";
    $resultat_etudiant = mysqli_query($connexion, $requete_etudiant);
    $donnees_etudiant = mysqli_fetch_assoc($resultat_etudiant);
    $nom = $donnees_etudiant['nom'];
    $prenom = $donnees_etudiant['prenom'];
    $classe = $donnees_etudiant['classe'];
    $filiere = $donnees_etudiant['filiere'];
    $matricules = $donnees_etudiant['Matricule'];
    $domaine = $donnees_etudiant['Domaine'];
    $somme_ponderee = 0;
    $somme_coefficients = 0;
    $credit_total = 0;
    $_SESSION['matricule'] = $matricules;
    ob_start();
?>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
    #money { display: flex; justify-content: center; padding: 20px; }
    .container { width: 930px; border: 1px dashed #000; padding: 50px; position: relative; height: auto; border-radius: 10px; }
    .logo { text-align: center; margin-bottom: 20px; }
    .logo img { width: 220px; }
    .header-band { background-color: rgb(137, 176, 199); border: 2px solid rgb(19, 53, 126); padding: 10px 0; text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px; }
    .student-name { text-align: center; font-size: 22px; font-weight: bold; margin-bottom: 15px; }
    .academic-year { text-align: right; margin-bottom: 15px; }
    .student-info { margin-bottom: 20px; }
    .student-info-row { display: flex; margin-bottom: 5px; }
    .student-info-label { width: 110px; font-weight: bold; }
    .student-info-value { flex: 1; }
    .semester-label { font-weight: bold; margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    table th, table td { border: 1px solid #000; padding: 8px; text-align: left; }
    table th { background-color: #f2f2f2; }
    .grades-total { text-align: right; font-weight: bold; }
    .footer-section { display: flex; margin-top: 40px; }
    .qr-code { width: 150px; height: 150px; }
    .summary { flex: 1; padding-left: 220px; margin-top: 40px; margin-left: 45px; }
    .summary-row { display: flex; margin-bottom: 10px; }
    .summary-label { width: 200px; font-weight: bold; }
    .summary-value { width: 200px; text-align: left; margin-left: 50px; }
    .date-signature { margin-top: 50px; text-align: right; }
    .signature { margin-top: 25px; font-weight: bold; text-align: right; margin-bottom: 100px; }
    .zert { margin-left: 15px; font-weight: bold; }
    #zou { color: red; }
</style>

<div><a href="index.php?pages=4"><div style="display: flex;"><div><img src="img/back.png" style="width: 25px; height: 20px; margin-top: 5px;"></div><div style="margin-top: 7px;">Retour</div></div></a></div>

<div id="money">
<div class="container">
    <div class="logo"><img src="img/logo.png"></div>
    <div class="header-band">RELEVE DE NOTES <?php echo $classe; ?></div>
    <div class="student-name"><?php echo $prenom." ". $nom; ?></div>
    <div class="academic-year"><p><strong>Année Académique:</strong> 2024-2025</p></div>
    <div class="student-info">
        <div class="student-info-row"><div class="student-info-label">Matricule</div><div class="student-info-value">: <?php echo $matricules; ?></div></div>
        <div class="student-info-row"><div class="student-info-label">DOMAINE</div><div class="student-info-value">: <?php echo $domaine; ?></div></div>
        <div class="student-info-row"><div class="student-info-label">MENTION</div><div class="student-info-value">: Sciences de l'Information et de la Communication</div></div>
        <div class="student-info-row"><div class="student-info-label">SPECIALITE</div><div class="student-info-value">: <?php echo $filiere; ?></div></div>
    </div>

    <div class="academic-year"><div class="semester-label">SEMESTRE : 1</div></div>

    <table>
        <tr><th>Nom ECU</th><th>Moyenne ECU</th><th>Coef.</th><th>CECT Obtenu</th><th>Validation ECU</th></tr>
        <?php
        $requete_notes = "SELECT matiere.nom_matiere, matiere.coef, note.valeur_note FROM note INNER JOIN matiere ON note.id_matiere = matiere.id_matiere WHERE note.mat_etu = '$matricules'";
        $req = mysqli_query($connexion, $requete_notes);
        while ($l = mysqli_fetch_assoc($req)) {
            $nom_matiere = $l['nom_matiere'];
            $note = $l['valeur_note'];
            $coefficient = $l['coef'];
            $statut = $note >= 10 ? "Valide" : "Non valide";
            $credit = $note >= 10 ? $coefficient : 0;
            $somme_ponderee += $note * $coefficient;
            $somme_coefficients += $coefficient;
            $credit_total += $credit;
            echo "<tr><td>$nom_matiere</td><td>$note</td><td>$coefficient</td><td>$credit</td><td>$statut</td></tr>";
        }
        $moyenne_generale = $somme_coefficients > 0 ? $somme_ponderee / $somme_coefficients : 0;
        $jury = $moyenne_generale != 30 ? "Semestre non Validé" : "Semestre validé";
        ?>
        <tr><td colspan="2" class="grades-total"></td><td class="grades-total"><?php echo $somme_coefficients; ?></td><td class="grades-total"><?php echo $credit_total; ?></td><td></td></tr>
    </table>

    <div class="footer-section">
        <div><?php include('qr.php'); ?><img src="<?php echo "img/qr/".$matricule.".png"; ?>" class="qr-code"></div>
        <div class="summary">
            <div class="summary-row"><div class="summary-label">Total CECT validés</div><div class="summary-value">:<span class="zert"><?php echo $credit_total; ?></span></div></div>
            <div class="summary-row"><div class="summary-label">Moyenne semestre 1</div><div class="summary-value">:<span class="zert"><?php echo $moyenne_generale; ?></span></div></div>
            <div class="summary-row"><div class="summary-label">Décision du Jury</div><div class="summary-value">:<span class="zert" id="zou"><?php echo $jury; ?></span></div></div>
        </div>
    </div>

    <div class="date-signature">
        Fait à Cotonou, le 
        <?php
        echo date("d");
        $mois = ["","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
        echo " ".$mois[intval(date("m"))]." ".date("Y");
        ?>
    </div>
    <div class="signature">SIGNATURE NUMERIQUE</div>
</div>
</div>

<?php
    $_SESSION['pdf'] = ob_get_clean();
    echo $_SESSION['pdf'];
?>
<?php
} else {
?>
<h3>Liste des étudiants</h3>
<table border="1" cellpadding="5" cellspacing="0">
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
                echo "<tr><td>{$row["Nom"]}</td><td>{$row["Prenom"]}</td><td>{$row["Matricule"]}</td><td>{$row["Filiere"]}</td><td>{$row["Classe"]}</td><td><a href='index.php?pages=4&matricule={$row['Matricule']}'>Consulter le bulletin</a></td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'><strong>Aucun étudiant trouvé</strong></td></tr>";
        }
    ?>
    </tbody>
</table>
<?php } ?>
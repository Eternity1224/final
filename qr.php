<?php
    include 'librairies/phpqrcode/qrlib.php';
    $dossier = __DIR__ . '/img/qr/';
    $chemin = $dossier . $matricules . '.png';
    if (!file_exists($dossier)) {
        mkdir($dossier, 0777, true);
    }
    if (is_writable($dossier)) {
        $texte = "Matricule: $matricules\nNom: $nom\n
        Prénom: $prenom\n
        Crédit Total: $credit_total\n
        Statut: $jury";
        QRcode::png($texte, $chemin);
    } else {
        echo "Erreur : impossible d'écrire dans le dossier $dossier.";
    }
?>

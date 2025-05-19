<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Gestion Bulletin</title>
</head>
<body>
<?php
include_once('connexion.php');
?>

<?php

function get_page_title($page) {
    switch ($page) {
        case '1':
            return 'Gestion des Étudiants';
        case '2':
            return 'Gestion des Matières';
        case '3':
            return 'Gestion des Notes';
        case '4':
            return 'Consultation du Bulletin de Notes';
        case '5':
            return 'Modification de la matière';
        case '6':
            return "Modification de l'Etudiant";
        case '7':
            return 'Modification des Notes';
        default:
            return 'Gestion bulletin de notes';
    }
}


$page = isset($_GET['pages']) ? $_GET['pages'] : '0';
$title = get_page_title($page);
?>
    <header>
        <h1><?php echo $title; ?></h1>
        <?php if ($page == '0'): ?>
            <p>Application web pour generer un bulletin</p>
        <?php endif; ?>
    </header>

    <nav>
        <a href="index.php">Accueil</a>
        <a href="index.php?pages=1">Étudiants</a>
        <a href="index.php?pages=2">Matières</a>
        <a href="index.php?pages=3">Notes</a>
        <a href="index.php?pages=4">Bulletin</a>
    </nav>
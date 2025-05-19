<?php
session_start();
require_once __DIR__ . '/librairies/vendor/autoload.php';

use Mpdf\Mpdf;

$html_content = $_SESSION['pdf'] ?? null;
$matricule = $_SESSION['matricule'] ?? 'inconnu';

if (!$html_content) {
    $html_content = "
        <h2 style='color: red;'>Aucun contenu PDF trouvé dans la session.</h2>
        <p>Assure-toi d'avoir d'abord généré la session via la page de bulletin.</p>
    ";
}

// Encapsulation dans un document HTML complet
$html = "
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Bulletin PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    $html_content
</body>
</html>
";

try {
    $mpdf = new Mpdf([
        'default_font' => 'dejavusans',
        'format' => 'A4',
        'orientation' => 'P'
    ]);

    $filename = "Bulletin_" . strtolower(str_replace(' ', '_', $matricule)) . ".pdf";

    $mpdf->WriteHTML($html);
    $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE); // Affiche dans le navigateur
} catch (\Mpdf\MpdfException $e) {
    echo "<h2>Erreur lors de la génération du PDF :</h2><pre>" . $e->getMessage() . "</pre>";
}
?>

<?php
include("auth.php");
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('elencoVolontari.html');

$dbAccess = new dbAccess();

try {
    $connessioneRiuscita = $dbAccess->openDBConnection();
} 
catch(Throwable $t) {
    header("Refresh: 3; url = /lscudele/chi_siamo.html", true, 301);
    echo "C'è stato un errore durante l'apertura del database";
}
catch(Exception $e) {
    header("Refresh: 3; url = /lscudele/chi_siamo.html", true, 301);
    echo "C'è stato un errore durante l'apertura del database";
}
  
if ($connessioneRiuscita) {

    $listaVolontari = $dbAccess->getListaVolontari();
    $dbAccess->closeDBConnection();

    $defVolontari = "";

    if ($listaVolontari != null) {
        
        $defVolontari = '<dl id="descrizioneVolontari">';

        foreach ($listaVolontari as $volontario) {

            $checkV = '';
            if ($volontario['Volontariato'] == 1) {
                $checkV = 'Ha gia fatto esperienze di volontariato';
            } else if ($volontario['Volontariato'] == 0) {
                $checkV = 'Non ha mai fatto esperienze di volontariato';
            }

            $checkA = '';
            if ($volontario['Animali'] == 1) {
                $checkA = 'ha già avuto animali';
            } else if ($volontario['Animali'] == 0) {
                $checkA = 'non ha mai avuto animali';
            }

            $defVolontari .= '<dt>' . $volontario['Nome'] .' '. $volontario['Cognome'] . '</dt>';
            $defVolontari .= '<dd>';
            $defVolontari .= '<p>Nato il ' . $volontario['DataNascita'] . ' e residente a ' . $volontario['Citta'] . ', numero di telefono: ' . $volontario['Telefono'] . '</p>';
            $defVolontari .= '<p>' . $checkV . ' e ' . $checkA . '. Può dedicare ' . $volontario['Ore'] . ' ore alla settimana al volontariato.</p>';
            $defVolontari .= '<q>' . $volontario['Motivazione'] . '</q>';
            $defVolontari .= '</dd>';
        }

        $defVolontari = $defVolontari . "</dl>";

    }
    else {
        $defVolontari = "<p>Non ci sono volontari registrati</p>";
    }

    echo str_replace("<elencoVolontari />", $defVolontari, $paginaHTML);
}


?>
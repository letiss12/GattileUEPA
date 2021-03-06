<?php
include("auth.php");
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('eliminaVolontario.html');

$dbAccess = new dbAccess();
$connessioneRiuscita = false;

try {
    $connessioneRiuscita = $dbAccess->openDBConnection();
} 
catch(Throwable $t) {
    header("Refresh: 3; url = /lscudele/home.html", true, 301);
    echo "C'è stato un errore durante l'apertura del database";
}
catch(Exception $e) {
    header("Refresh: 3; url = /lscudele/home.html", true, 301);
    echo "C'è stato un errore durante l'apertura del database";
}


if ($connessioneRiuscita == true) {
  
    $listaVol = $dbAccess->getListaVolontari();
    $dbAccess->closeDBConnection();

    $defForm = '';
    if ($listaVol != null) {

        $defForm = '<fieldset><legend>Persone a disposizione del rifugio</legend>';

        foreach ($listaVol as $vol) {
            $ID = $vol['ID'];
            $nome = $vol['Nome'];
            $cognome = $vol['Cognome'];
            $nomID = $nome.$ID;
            $nomID = trim($nomID);
            $defForm .= '<input type="checkbox" name="delete[]" value="' . $ID . '" id="' . $nomID . '"/>';
            $defForm .= '<label for="' . $nomID . '">' . $nome . ' ' . $cognome . '</label><br />';
        }

        $defForm .= '</fieldset><fieldset><legend>Rimuovi i volontari selezionati</legend><button type="submit" value="submit" name="final_delete">Elimina</button></fieldset>';
        
    }

}

echo str_replace("<valoreForm />", $defForm, $paginaHTML);

?>
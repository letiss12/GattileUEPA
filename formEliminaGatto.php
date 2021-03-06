<?php
include("auth.php");
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('eliminaGatto.html');

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
   
    $listaGatti = $dbAccess->getListaGatti();
    $dbAccess->closeDBConnection();

    $defForm = '';
    if ($listaGatti != null) {

        $defForm = '<fieldset><legend>Gatti registrati al rifugio</legend>';

        foreach ($listaGatti as $gatto) {
            $ID = $gatto['ID'];
            $nome = $gatto['Nome'];
            $nomeF = $gatto.$ID;
            $nomeF = trim($nomeF);
            $defForm .= '<input type="checkbox" name="delete[]" value="' . $ID . '" id="' . $nomeF . '"/>';
            $defForm .= '<label for="' . $nomeF . '">' . $nome . '</label><br />';
        }

        $defForm .= '</fieldset><fieldset><legend>Rimuovi i gatti selezionati</legend><button type="submit" value="submit" name="final_delete">Elimina</button></fieldset>';
        
    }

}

echo str_replace("<valoreForm />", $defForm, $paginaHTML);

?>
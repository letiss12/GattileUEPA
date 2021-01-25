<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('home.html');

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

$cont = '';
if ($connessioneRiuscita == true) {

    $gatti = $dbAccess->getNumAdottati();
    $dbAccess->closeDBConnection();

    $cont = '<p>Al momento sono stati adottati già '. $gatti . ' gatti! Unisciti alla comunity!</p>';

}

str_replace("<contaGatti />", $cont, $paginaHTML);
echo $paginaHTML;
?>
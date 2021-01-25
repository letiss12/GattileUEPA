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


if ($connessioneRiuscita == true) {

    $gatti = $dbAccess->getNumAdottati();
    $dbAccess->closeDBConnection();




    echo str_replace("<contaGatti />", $gatti, $paginaHTML);
}

?>
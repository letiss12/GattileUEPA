<?php
include("auth.php");
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('nuovoGattoForm.html');

$messaggioPerForm = '';
$nome = ''; $genere = ''; $adozione = ''; $descrizione = '';

if (isset($_POST['submit'])) {

    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];
    $adozione = $_POST['adozione'];
    $genere = $_POST['genere'];
    $imm = '';

    $matchN = '';
    $regexN = '/^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/';
    if (preg_match($regexN, $nome)) {
        $matchN = true;
    } else {
        $matchN = false;
    }
    if ($matchN == true) {
        $messaggioPerForm = '<p>match true</p>';
    } else if ($matchN == false) {
        $messaggioPerForm = '<p>match false</p>';
    }

    $dbAccess = new DBAccess();
    $openDBConnection = $dbAccess->openDBConnection();

    if ($openDBConnection == false) {
        die ("C'è stato un errore durante l'apertura del database");
    } else {

        if ($matchN==true && strlen($descrizione) >= 10) {
            $risultatoInserimento = $dbAccess->inserisciGatto($nome, $genere, $adozione, $descrizione, $imm); 
            $dbAccess->closeDBConnection();

            if($risultatoInserimento == false){
                $messaggioPerForm .= '<div class="messForm"><p>Si è verificato un errore nella registrazione del gatto, riprova per favore.</p></div>';
            } else if ($risultatoInserimento == true)  {
                $messaggioPerForm .= '<div class="messForm"><p>Un nuovo piccolo felino è stato registrato al rifugio!</p></div>';
                $nome = ''; $descrizione = '';
            }
        }
        else {
            $dbAccess->closeDBConnection();
            $messaggioPerForm .= '<div class="messForm"><ul>';
            if ($matchN == false) {
                $messaggioPerForm .= '<li>Il nome del gatto è troppo corto per essere inserito</li>';
            }
            if (strlen($descrizione) < 10) {
                $messaggioPerForm .= '<li>Inserire una descrizione di almeno 10 caratteri per il gatto</li>';
            }
            $messaggioPerForm .= '</ul></div>';
        }   

    }


}

$paginaHTML = str_replace('<messaggiForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valoreDescr />', $descrizione, $paginaHTML);

echo $paginaHTML;

?>
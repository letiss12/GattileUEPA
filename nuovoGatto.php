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
    $imm = "";
    if ($genere == 1) {
        $imm = "gatto_femmina.jpg";
    } else if ($genere == 0) {
        $imm = "gatto_maschio.jpg";
    }

    $matchN = '';
    $regexN = '/^[a-zA-Z]{2}[a-zA-Z\s]{0,28}$/';
    if (preg_match($regexN, $nome)) {
        $matchN = true;
    } else {
        $matchN = false;
    }

    $matchD = '';
    $regexD = '/.{10,}/';
    if (preg_match($regexD, $descrizione)) {
        $matchD = true;
    } else {
        $matchD = false;
    }
    
    $descrizione = htmlentities($descrizione);


    $dbAccess = new DBAccess();
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

        if ($matchN==true && $matchD == true) {
            $risultatoInserimento = $dbAccess->inserisciGatto($nome, $genere, $adozione, $descrizione, $imm); 
            $dbAccess->closeDBConnection();

            if($risultatoInserimento == false){
                $messaggioPerForm .= '<div class="messForm"><p>Si è verificato un errore nella registrazione del gatto, riprova per favore.</p></div>';
            } else if ($risultatoInserimento == true)  {
                $messaggioPerForm .= '<div class="messForm"><p>Un nuovo piccolo felino è stato registrato al rifugio!</p><button><a href="vistaGatti.php">Torna alla Gestione Gatti</a></button></div>';
                $nome = ''; $descrizione = '';
            }
        }
        else {
            $dbAccess->closeDBConnection();
            $messaggioPerForm .= '<div class="messForm"><ul>';
            if ($matchN == false) {
                $messaggioPerForm .= '<li>Il nome del gatto è troppo corto per essere inserito</li>';
            }
            if ($matchD == false) {
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
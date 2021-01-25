<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;
$paginaHTML = file_get_contents('volontario.html');
$messaggioPerForm = '';
$nome = ''; $cognome = ''; $dataNascita = ''; $citta = ''; $telefono = ''; $volontario = ''; $animali = ''; $ore = ''; $motivazione = '';

if (isset($_POST['submit'])) { 

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $dataNascita = $_POST['dataNascita'];
    $citta = $_POST['citta'];
    $telefono = $_POST['telefono'];
    $volontario = $_POST['volontariato'];
    $animali = $_POST['animali'];
    $ore = $_POST['oreVol'];
    $motivazione = $_POST['motivazione'];
    $regexNCC = '/^[a-zA-Z]{2}[a-zA-Z\s\']{0,28}$/';
    $regexD = '/^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/](19\d{2}|20\d{2})$/';
    $regexT = '/\d{9,10}/';
    $regexO = '/^[1-9]{1}[0-9]{0,2}$/';
    $regexM = '/.{30,}/';

    $checkN = '';
    if (preg_match($regexNCC, $nome)) {
        $checkN = true;
    } else { $checkN = false; }
    $checkCo = '';
    if (preg_match($regexNCC, $cognome)) {
        $checkCo = true;
    } else { $checkCo = false; }
    $checkCi = '';
    if (preg_match($regexNCC, $citta)) {
        $checkCi = true;
    } else { $checkCi = false; }
    $checkD = '';
    if (preg_match($regexD, $dataNascita)) {
        $checkD = true;
    } else { $checkD = false; }
    $checkT = '';
    if (preg_match($regexT, $telefono)) {
        $checkT = true;
    } else { $checkT = false; }
    $checkO = '';
    if (preg_match($regexO, $ore)) {
        $checkO = true;
    } else { $checkO = false; }
    $checkM = '';
    if (preg_match($regexM, $motivazione)) {
        $checkM = true;
    } else { $checkM = false; }

    $motivazione = htmlentities($motivazione);

    

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
        
        if ($checkN == true && $checkCo == true && $checkD == true && $checkCi == true && $checkT == true && $checkO == true && $checkM == true ) {
            $risultatoInserimento = $dbAccess->inserisciVolontario($nome, $cognome, $dataNascita, $citta, $telefono, $volontario, $animali, $ore, $motivazione);
            $dbAccess->closeDBConnection();

            if($risultatoInserimento == false){
                $messaggioPerForm = '<div class="messForm"><p class="errore>Si è verificato un errore nell\'invio della tua richiesta. Riprova per favore.</p></div>';
            } else if ($risultatoInserimento == true)  {
                $messaggioPerForm = '<div class="messForm"><p class="completato>La tua richiesta è stata inviata correttamente, un sentito grazie da parte dello staff e di tutti i gatti!</p></div>';
                $nome = ''; $cognome = ''; $dataNascita = ''; $citta = ''; $telefono = ''; $volontario = ''; $animali = ''; $ore = ''; $motivazione = '';
            }

        } else {
            $dbAccess->closeDBConnection();
            $messaggioPerForm = '<div class="messForm><ul>';
            if ($checkN == false) {
                $messaggioPerForm .= '<li>Il nome inserito è troppo corto</li>';
            }
            if ($checkCo == false) {
                $messaggioPerForm .= '<li>Il cognome inserito è troppo corto</li>';
            }
            if ($checkD == false) {
                $messaggioPerForm .= '<li>La data di nascita è stata inserita in modo errato, la forma corretta è GG/MM/AAAA</li>';
            }
            if ($checkCi == false) {
                $messaggioPerForm .= '<li>Il nome della città inserita è troppo corto</li>';
            }
            if ($checkT == false) {
                $messaggioPerForm .= '<li>Il numero di telefono inserito è troppo corto</li>';
            }
            if ($checkO == false) {
                $messaggioPerForm .= '<li>Inserire un numero maggiore di zero</li>';
            }
            if ($checkM == false) {
                $messaggioPerForm .= '<li>La tua spiegazione deve essere di almeno 30 caratteri</li>';
            }
   
            $messaggioPerForm .= '</ul></div>';
        }

    }
}


$paginaHTML = str_replace('<messaggiForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valoreCognome />', $cognome, $paginaHTML);
$paginaHTML = str_replace('<valoreData />', $dataNascita, $paginaHTML);
$paginaHTML = str_replace('<valoreCitta />', $citta, $paginaHTML);
$paginaHTML = str_replace('<valoreTelefono />', $telefono, $paginaHTML);
$paginaHTML = str_replace('<valoreOre />', $ore, $paginaHTML);
$paginaHTML = str_replace('<valoreMotiv />', $motivazione, $paginaHTML);

echo $paginaHTML;


?>
<?php
require __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: gestione.php");
    exit;
}
$mess ='';
$pagina = file_get_contents('login.html');
if (isset($_POST['username'])){
     
    $username = $_POST['username'];
    $password = $_POST['password'];	
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
       
        $admin = $dbAccess->getAdmin($username, $password);
        $dbAccess->closeDBConnection();

        if ($admin == 1) {
            $_SESSION['username'] = $username;
            $_SESSION["loggedin"] = true;
            header("Location: gestione.php");
        } else {
            $mess = '<p>Username o password non corretti. Riprova.</p>';
        }
    }
} 

$pagina = str_replace('<messForm />', $mess, $pagina);

echo $pagina;   

?>
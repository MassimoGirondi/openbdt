<?php
require("../comuni/lib.php");
autentica(UTENTE);
dbconnect();
//require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
	$id=$_SESSION['id'];
	$password=$_REQUEST['password1'];
	cambia_password($id,$password);
	echo "Operazione effettuata";	
	header('Location: ./mod_dati.php' );	
}

?>

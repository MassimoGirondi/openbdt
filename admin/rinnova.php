<?php
require("../comuni/lib.php");
autentica(ADMIN);
dbconnect();
if(isset($_REQUEST['id']))
{
	rinnova_utente($_REQUEST['id']);
}

header('Location: ./elenco.php' );	

?>


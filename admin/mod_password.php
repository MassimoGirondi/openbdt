<?php
require("../comuni/lib.php");
autentica(ADMIN);
$titolo="Modifica password utente";
require("../comuni/header.php");
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
	$id=$_REQUEST['id'];
	$password=$_REQUEST['password1'];
	cambia_password($id,$password);
	//invia_mail(id_to_mail($id),"Nuova Password","Questa &egrave; la tua nuova password, non dimenticarla!.\n<br/> "
  //              . "Utente:  ".  id_to_user($id)."\n<br/>Password: ".$password);
        mailer_new(id_to_mail($id),
                "$nomebdt - Nuova passsword",
                "<html><body>Ciao, questa &egrave; un amministratore ha cambiato la tua password.<br/>/n"
                . "<br/>La tua nuova password &egrave;: $password"
                . "<br/>Il tuo nome utente &egrave;: ".  id_to_user($id)
                . "<br/>Ti consigliamo di cambiare la password alla prima occasione e di scrivertela in un posto sicuro."
                . "<br/><a href=\"$home\">"
                . "Clicca qui per andare sul sito</a></body></html>");
	echo "Operazione effettuata";
	header('Location: ./elenco.php' );	
}
else
{
	$id=$_REQUEST['id'];
	$sql="SELECT id,login,nome,cognome,mail,cellulare FROM users WHERE id = $id";
	$ris=mysql_safe_query($sql);
	$ris=mysql_fetch_row($ris);
	$login=$ris[1];
	$nome = $ris[2];
	$cognome = $ris[3];
?>

<FORM action="" method="POST" onsubmit="return testpass(this)">
	<P>
		Stai per cambiare la password all'utente <?=$login?> (<?=$nome?> <?=$cognome?>).<br/>
		
		
		<LABEL for="password1">Nuova password: </LABEL>
		<INPUT type="password" name="password1" autocomplete="off" required/>
		<br/>
		<LABEL for="password2">Reinserisci: </LABEL>
		<INPUT type="password" name="password2" autocomplete="off" required/>
		<br/>
		<br/>
		<input type="hidden" name="id" value="<?=$id?>">
		Cliccando su conferma modificherai la password e invierai un'e-mail all'utente con le nuove credenziali.<br/>
		<input name="cmd" type="submit" value="Conferma" />
  		<input name="cmd" type="reset" value="Reset" />
	</P>
	
</FORM>

<?php
}

require("../comuni/footer.php");
?>

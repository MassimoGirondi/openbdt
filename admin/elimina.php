<?
require("../comuni/lib.php");
autentica(ADMIN);
$titolo="Eliminazione utente";
require("../comuni/header.php");
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
	$id=$_REQUEST['id'];
	elimina($id);
	echo "Operazione effettuata";
	header('Location: ./elenco.php' );	
}
else
{
	$id=$_REQUEST['id'];
	$sql="SELECT id,login,nome,cognome FROM users WHERE id = $id";
	$ris=mysql_safe_query($sql);
	$ris=mysql_fetch_row($ris);
	$login=$ris[1];
	$nome = $ris[2];
	$cognome = $ris[3];
?>

<FORM action="" method="POST" >
	<P>
		Stai per eliminare l'utente <?=$login?> (<?=$nome?> <?=$cognome?>).Questa operazione non può essere annullata<br/>

		<input type="hidden" name="id" value="<?=$id?>">
		<input name="cmd" type="submit" value="Conferma" />
  		<input name="cmd" type="button" value="Annulla" onClick="document.location='./elenco.php'"/>
	</P>
	
</FORM>

<?
}

require("../comuni/footer.php");
?>

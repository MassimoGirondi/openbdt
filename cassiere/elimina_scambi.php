<?
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
//eliminazione
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Eliminazione scambi";
require("../comuni/header.php");
$scambi1=$_REQUEST['scambi'];
$scambi=explode(',', $scambi1);
foreach($scambi as &$x) 
		{echo $x;
		elimina_scambio($x);}
	header('Location: ./conferma_scambi.php' );	
}

?>
<FORM action="elimina_scambi.php" method="POST" >
Sicuro di voler eliminare i seuenti scambi? Questa operazione non può essere annullata!
<table>
	<tr>
		<td>Fornitore</td>
		<td>Cliente</td>
		<td>Ore</td>
		<td>Data</td>
		<td>Descrizione</td>
	</tr>

<?	
		foreach($scambi as &$x) {
		$s=mysql_fetch_row(ottieni_scambio($x));
		
		?>		<tr>
				
				<td><?=$s[6]." ".$s[7]."(".$s[8].")"?></td>
				<td><?=$s[9]." ".$s[10]."(".$s[11].")"?></td>
				<td><?=$s[3]?></td>
				<td><?=$s[4]?></td>
				<td><?=$s[5]?></td>
				</tr>
	
	<?
	}
	
	?>
	<input type="hidden" name="scambi" value="<? echo implode(',',$scambi);?>"/>
	</TABLE>
<br/>
    </button>
    <button class="btn waves-effect waves-light" type="button" name="cmd" onclick="document.location='./conferma_scambi.php'" value="Annulla">Annulla
    </button>
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Elimina
    <i class="mdi-action-delete right"></i>
	<!--<input name="cmd" type="submit" value="Conferma"></input>
  	<input name="cmd" type="reset" value="Reset"/>-->
	
	</FORM>

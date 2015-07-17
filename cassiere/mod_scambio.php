<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Modifica scambio";
require("../comuni/header.php");
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{//se arrivo dopo aver modificato lo scambio
	
	$fornitore=$_REQUEST['fornitore'];
	preg_match('#\((.*?)\)#', $fornitore, $match);
	$fornitore=login_to_id($match[1]);
	
	$cliente=$_REQUEST['cliente'];
	preg_match('/\((.*?)\)/', $cliente, $match);
	$cliente=login_to_id($match[1]);
	if($fornitore!=0 && $cliente!=0)
	{
		$ore=$_REQUEST['ore'];
		$data=$_REQUEST['data'];
		$descrizione=trim($_REQUEST['descrizione']);
	
	$id=agg_scambio($fornitore,$cliente,$ore,$data,$descrizione);
	if(isset($_REQUEST['conferma']))
		scambio_confermato($id);
	header('Location: ./agg_scambio_terzo.php' );	
	}
}
else
{//se lo modifico arrivo con una chiamata get con parametro id
	$id=$_REQUEST['id'];
	$scambio=ottieni_scambio($id);
	echo $fornitore=nome_utente($scambio[1]);
	$cliente=nome_utente($scambio[2]);
	$ore=$scambio[3];
	$data=$scambio[4];
	$descrizione=$scambio[5];
	$conferma=$scambio[6];
$utenti=utenti();
?>
<h1>NON FUNZIONA!!!</h1>

    <FORM action="" method="POST" >
	<P>
<LABEL for="cliente">Cliente: </LABEL>
<select name="cliente" autocomplete=off>

<?
	while($r=mysql_fetch_row($utenti))
	{	
		if($r[0]!=nome_utente($_SESSION['id']))
		{?>
		
                <option value="<?=$r[0]?>"><?=$r[0]?></option>
  		<?}
  	}
?>
</select>
<br/>

<LABEL for="fornitore">Fornitore: </LABEL>
<select name="fornitore" autocomplete=off>

<?php  mysql_data_seek($utenti,0);
	while($r=mysql_fetch_row($utenti))
	{	
		if($r[0]!=nome_utente($_SESSION['id']))
		{?>
		
                <option value="<?=$r[0]?>"><?=$r[0]?></option>
  		<?php
                
                }
  	}
?>
</select>
<br/>
<LABEL for="data">Data Prestazione: </LABEL>
<input name="data" type=date min="2000-01-01" max="<?=domani();?>"/><br/>
<LABEL for="ore">Ore: </LABEL>
<input name="ore" type=number min=0.5 max=5 step=0.5 value=0.5 /><br/>
<LABEL for="descrizione">Descrizione: </LABEL>
<input name="descrizione" type=text  maxlength="25"  /><br/>
<LABEL for="conferma">Confermato?: </LABEL>
<input name="conferma" type=checkbox checked  /><br/>
<input name="cmd" type="submit" value="Conferma" />
<input name="cmd" type="reset" value="Reset" />
</P>
</FORM>

<?php
}
require("../comuni/footer.php");
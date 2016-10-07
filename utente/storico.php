<?php
require("../comuni/lib.php");
autentica(UTENTE);
$titolo="Visualizza il tuo storico";
require("../comuni/header.php");
$id=$_SESSION['id'];
?>

<h4>Il tuo saldo è di <?=id_to_saldo($id)?> ore. <br/>
Fino ad oggi hai scambiato <?=ore_tot_by_id($id)?> ore.<br/>
Questo è il tuo estratto conto: </h4>
<?php
    $intest=array("Utente","Data","Descrizione","ore");
    $dim=array("25%","20%","40%","15%");
    $righe=array();
    $scambi= scambi_by_id_array($_SESSION['id']);
    foreach ($scambi as $s)
    {if(isset($s[0]))
        $righe[]=array($s[0],$s[1],$s[2],$s[3]);
    }
    agg_tabella($intest, $righe, $dim, "storico");
/*
?>

<table>
	<tr>
		<td>Utente</td>
		<td>Data</td>
		<td>Descrizione</td>
		<td>Ore</td>
	</tr>

<?php
	echo scambi_by_id($id);
?>
	</TABLE>

<?php
*/
require("../comuni/footer.php");?>

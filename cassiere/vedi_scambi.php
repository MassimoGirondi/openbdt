<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Visualizza scambio";
require("../comuni/header.php");
echo "<br/>";
$scambi=scambi();
if($scambi!=null){

$intest=array("Fornitore","Cliente","Ore","Data","Descrizione","Confermato");

$righe=array();
while($s=mysql_fetch_row($scambi))
{
    $righe[]=array("$s[6] $s[7] ($s[8]) ","$s[9] $s[10] ($s[11])",$s[3] ,$s[4],$s[5],$s[12]?"si":"no");
}
$dim=array("20%","20%","20%","20%%","15%","5%");
agg_tabella($intest, $righe, $dim, "vedi_scambi");


/*
 ?>
 
<table>
	<tr>
		<td>Fornitore</td>
		<td>Cliente</td>
		<td>Ore</td>
		<td>Data</td>
		<td>Descrizione</td>
		<td>Confermato</td>
	</tr>

<?php
	while($s=mysql_fetch_row($scambi))
	{
		?>		<tr>
				<td><?=$s[6]." ".$s[7]."(".$s[8].")"?></td>
				<td><?=$s[9]." ".$s[10]."(".$s[11].")"?></td>
				<td><?=$s[3]?></td>
				<td><?=$s[4]?></td>
				<td><?=$s[5]?></td>
				<td><?=$s[12]?"si":"no"?></td>
				</tr>
	
	<?php
	}
	
	?>
	</TABLE>

<?php*/
}
else echo "Qui non c'è niente!";
require("../comuni/footer.php");?>

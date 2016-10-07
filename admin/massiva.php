<?php
require("../comuni/lib.php");
autentica(ADMIN);
$titolo="Approvazione utenti";
require("../comuni/header.php");

if(isset($_REQUEST['check']))
{
    //echo "settato";

    $check = $_REQUEST['check'];
    foreach ($check as &$x) {
        //se ci sono scambi confermati li confermiamo e torniano alla stessa pagina
        conferma_utente($x);
        echo "confermato $x \n";
    }
    header("Location: elenco.php");
}
echo "<br/><form method=\"POST\"> OCIO CHE QUA NON FUNSIA NIENTE";

$ris=  utenti_inattesa();

$intest=array("Login","Nome","Cognome","Mail","Cellulare","Codice Fiscale","<input type=\"checkbox\" onclick=\"toggle(this);\" class=\"filled-in\" name=\"all\" id=\"all\"value=\"all\"/><label for=\"all\" style=\"width: 0px;\"></label>");//<input type=\"checkbox\" onClick=\"toggle(this)\" id=\"all\"  /><label for=\"all\" style=\"width: 0px;\"></label>");
$righe=array();
while($ut=mysql_fetch_row($ris))
{
    $righe[]=array($ut[1],$ut[2],$ut[3],$ut[4],$ut[5],$ut[6]," <input type=\"checkbox\" class=\"filled-in\" name=\"check[]\" id=\"check[]\" value=\"<?= $ut[0] ?>\"/>
            <label for=\"check[]\" style=\"width: 0px;\"></label>");
}
 $dim=array("15%","15%","15%","15%","15%","20%","5%");
            agg_tabella($intest, $righe, $dim, "massiva");
//intestazione tabella
/* ?>
<br/>
<FORM action="" method=POST>
<table>
	<tr>
		<td>Login</td>
		<td>Nome</td>
		<td>Cognome</td>
		<td>Mail</td>
		<td>Cellulare</td>
                <td>Codice Fiscale</td>
                <td>
                    <input type="checkbox" onclick="toggle(this);" class="filled-in" name="all" id="all"value="all"/><label for="all" style="width: 0px;"></label>
                </td>
		
	</tr>



<?php
while($ut=mysql_fetch_row($ris))
{
//riga della tabella:
?>
	<tr>
	<td><?=$ut[1]?></td>
	<td><?=$ut[2]?></td>
	<td><?=$ut[3]?></td>
	<td><?=$ut[4]?></td>
        <td><?=$ut[5]?></td>
        <td><?=$ut[6]?></td>
        <td>
            <input type="checkbox" class="filled-in" name="check[]" id="check[]" value="<?= $ut[0] ?>"/>
            <label for="check[]" style="width: 0px;"></label>
        </td>
	</tr>
<?php
}
 * */
 
?>
</table>
   <!-- <input name="cmd" type="submit" value="Conferma"></input>
    <input name="cmd" type="submit" value="Elimina"></input>
    <input name="cmd" type="reset" value="Reset"/>
    --><br/>
        <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Elimina">Elimina
    <i class="mdi-action-delete right"></i>
    </button>
    <script>
            $("#massiva").tablesorter({headers:{6:{sorter:false}}});
            </script>
</form>
<?php

require("../comuni/footer.php");
?>


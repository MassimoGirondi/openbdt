<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Visualizza lo storico";
require("../comuni/header.php");

?>



<form action="" method="POST">
    <div class="row">
        <div class="col s6">
            <label for="utente">Utente:</label>
                <select autocomplete=off name="utente" class="browser-default">
                     <?php print_utenti();?>
                </select>
        </div>
        &nbsp;
        <div class="col s6" style="bottom: 0;">
        <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma" >Conferma
    <i class="mdi-content-send right"></i>
    </button>
    </div>
    </div>
</P>
</form>


</form>

<?php
$ok=false;
if(isset($_REQUEST['id']))
{
    $id=$_REQUEST['id'];
    $ok=true;
}

else if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{
	//$utente=$_REQUEST['utente'];
	//preg_match('#\((.*?)\)#', $utente, $match);
	//$id=login_to_id($match[1]);
       $id=$_REQUEST['utente'];
    $ok=true;
}
if($ok)
{
?><br/>
<h4>
Utente: <?=nome_utente($id)?><br/>
Il saldo è di <?=id_to_saldo($id)?> ore. <br/>
Fino ad oggi ha scambiato <?=ore_tot_by_id($id)?> ore.<br/>
Questo è il suo estratto conto: </h4>

<?php
$intest=array("Utente","Data","Descrizione","ore");
    $dim=array("25%","20%","40%","15%");
    $righe=array();
    $scambi= scambi_by_id_array($id);
    foreach ($scambi as $s)
    {if(isset($s[0]))
        $righe[]=array($s[0],$s[1],$s[2],$s[3]);
    }
    agg_tabella($intest, $righe, $dim, "storico");
}
require("../comuni/footer.php");
?>

<?php
require("../comuni/lib.php");
autentica(CASSIERE);
dbconnect();
$titolo="Visualizza tutte le attivit&agrave;";
require("../comuni/header.php");
if(isset($_REQUEST['el']))
    { 
    
        echo "elimina ".$_REQUEST['el']."\n ";
        elimina_abilita_cassiere($_REQUEST['el']);
        header("Location: tutte_abilita.php");
    }
    
else
{
    ?>

     <div class="row">
       <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Inserisci nuova abilit&agrave;" onclick="document.location='mod_abilita.php'" />Inserisci nuova abilit&agrave;
            <i class="mdi-content-add right"></i>
        </button>
    </div>

    <?php
    $intest=array("Utente","Categoria","sub Categoria","Note","Azioni");
    $dim=array("10%","15%","20%","30%","25%");
    $abi= abilitas_cassiere();
    $righe=array();
    while($r=  mysql_fetch_row($abi))
{
        $azioni="<button value=\"Elimina\" class=\"btn waves-effect waves-light\" onclick=\"conferma('Sicuro di voler eliminare l\'abilit&agrave;?','tutte_abilita.php?el=$r[4]')\">Elimina</button>&nbsp;
                <button value=\"Elimina\" class=\"btn waves-effect waves-light\" onclick=\"document.location='mod_abilita.php?mod=$r[4]'\" >Modifica</button>";
        $righe[]=array($r[0], $r[1], $r[2], $r[3], $azioni );

}
            $dim=array("10%","15%","20%","30%","25%");
        agg_tabella($intest, $righe, $dim, "tutte_abilita");
    /*
    
    
?><br/>
<input type="button" value="Inserisci nuova abilit&agrave;" onclick="document.location='mod_abilita.php'"/><br/>
<table>
	<tr>
                <td width="10%">Utente</td>
		<td width="15%">Categoria</td>
		<td width="20%">Sub Categoria</td>
		<td width="30%">Note</td>
                <td width="25%">Azioni</td>
	</tr>
<?php
$abi= abilitas_cassiere();
while($r=  mysql_fetch_row($abi))
{
    ?>
        <tr>
            <td><?=$r[0]?></td>
            <td><?=$r[1]?></td>
            <td><?=$r[2]?></td>
            <td><?=$r[3]?></td>
            <td>
                <input type="button" value="Elimina" onclick="conferma('Sicuro di voler eliminare l\'abilit&agrave;?','tutte_abilita.php?el=<?=$r[4]?>')" />
                <input type="button" value="Modifica" onclick="document.location='mod_abilita.php?mod=<?=$r[4]?>'" />
            </td>
        </tr>
    <?php
}
}
echo "</table>";*/
}
require("../comuni/footer.php");

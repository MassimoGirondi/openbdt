<?php
if(isset($_REQUEST['el']))
    {
        require("../comuni/lib.php");
        autentica(UTENTE);
        dbconnect();
        elimina_abilita($_REQUEST['el'], $_SESSION['id']);
        header("Location: ./mod_dati.php");
    }
    
else
{//frame visualizzato all'interno del fieldset nella pagina dei dati
$abi=  abilitas_by_uid($_SESSION['id']);
?>
<button class="btn waves-effect waves-light" type="button" name="cmd" onclick="document.location='mod_abilita.php'" value="Inserisci nuova abilit&agrave;">Inserisci nuova abilit&agrave;
    <i class="mdi-content-add right"></i>
    </button>  <br/>
<?php /*
<!--<input type="button" value="Inserisci nuova abilit&agrave;" onclick="document.location='mod_abilita.php'"/><br/>-->

<table>
	<tr>
		<td width="15%">Categoria</td>
		<td width="20%">Sub Categoria</td>
		<td width="40%">Note</td>
                <td width="25%">Azioni</td>
	</tr>
<?php


while($r=  mysql_fetch_row($abi))
{
    ?>
        <tr>
            <td><?=$r[0]?></td>
            <td><?=$r[1]?></td>
            <td><?=$r[2]?></td>
            <td>
                <input type="button" value="Elimina" onclick="conferma('Sicuro di voler eliminare l\'abilit&agrave;?','mie_abilita.php?el=<?=$r[3]?>')" />
                <input type="button" value="Modifica" onclick="document.location='mod_abilita.php?mod=<?=$r[3]?>'" />
            </td>
        </tr>
    <?php
    
}*/


    $intest=array("Categoria","Sub Categoria","Note","Azioni");
    $dim=array("15%","20%","40%","25%");
    $righe=array();
    while($s=mysql_fetch_row($abi))
    {
    $righe[]=array($s[0], $s[1], $s[2],
            "<div class=row><button class=\"btn waves-effect waves-light\" onclick=\"conferma('Sicuro di voler eliminare l\'abilit&agrave;?','mie_abilita.php?el=$s[3]')\" type=\"button\" name=\"elimina\">Elimina</button>\n"
          . "<button class=\"btn waves-effect waves-light\" onclick=\"document.location='mod_abilita.php?mod=$s[3]'\" type=\"button\" name=\"modifica\">Modifica</button></div>");

    
    
    }
    agg_tabella($intest, $righe, $dim, "mie_abilita");




}

<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo = "Conferma scambi";
require("../comuni/header.php");
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma") && isset($_REQUEST['check']) && count($_REQUEST['check']) > 0) {
    $check = $_REQUEST['check'];
    foreach ($check as &$x) {
        scambio_confermato($x);
    }
    header('Location: ./conferma_scambi.php');
} else if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Elimina") && isset($_REQUEST['check']) && count($_REQUEST['check']) > 0) {
//chiamare la pagina elimina_scambi.php
    $scambi = $_REQUEST['check'];
    require("elimina_scambi.php");
} else {

    $scambi = scambi_da_confermare();
    if ($scambi != null && mysql_numrows($scambi)!=0) {
        ?>
        <FORM action="" method="POST" >
            <table>
                <tr>
                    <td>Fornitore</td>
                    <td>Cliente</td>
                    <td>Ore</td>
                    <td>Data</td>
                    <td>Descrizione</td>
                    <td><input type="checkbox" onClick="toggle(this)" /></td>
                </tr>

                <?php //s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.nome,f.cognome,f.login,c.nome,c.cognome,c.login
                while($s=mysql_fetch_row($scambi))
                {
                ?>		<tr>
                    <td><?= $s[6] . " " . $s[7] . "(" . $s[8] . ")" ?></td>
                    <td><?= $s[9] . " " . $s[10] . "(" . $s[11] . ")" ?></td>
                    <td><?= $s[3] ?></td>
                    <td><?= $s[4] ?></td>
                    <td><?= $s[5] ?></td>
                    <td><input type="checkbox" name="check[]" value="<?= $s[0] ?>"></td>
        </tr>

        <?php   }   ?>
    </TABLE>
    <input name="cmd" type="submit" value="Conferma"></input>
    <input name="cmd" type="submit" value="Elimina"></input>
    <input name="cmd" type="reset" value="Reset"/>

</FORM>
<?php
}

else
{echo "Nessuno scambio da confermare!";}}	
require("../comuni/footer.php");?>


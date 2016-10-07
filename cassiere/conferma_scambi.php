<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo = "Conferma scambi";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma") && isset($_REQUEST['check']) && count($_REQUEST['check']) > 0) {
    $check = $_REQUEST['check'];
    foreach ($check as &$x) {
        scambio_confermato($x);//se ci sono scambi confermati li confermiamo e torniano alla stessa pagina
    }
    header('Location: ./conferma_scambi.php');
} else 
    if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Elimina") && isset($_REQUEST['check']) && count($_REQUEST['check']) > 0) {
    //chiamare la pagina elimina_scambi.php
    $scambi = $_REQUEST['check'];
    require("elimina_scambi.php");
} else {

    $scambi = scambi_da_confermare();
    if ($scambi != null && mysql_numrows($scambi)!=0) {
        ?>
        <FORM action="" method="POST" >
            <br/>
            <?php 
            //echo "<input type=\"checkbox\" onclick=\"toggle(this);\" class=\"filled-in\" name=\"all\" id=\"all\"value=\"all\"/><label for=\"all\" style=\"width: 0px;\"></label>";
            $intest=array("Fornitore","Cliente","Ore","Data","Descrizione","<input type=\"checkbox\" onclick=\"toggle(this);\" class=\"filled-in\" name=\"all\" id=\"all\"value=\"all\"/><label for=\"all\" style=\"width: 0px;\"></label>");//<input type=\"checkbox\" onClick=\"toggle(this)\" id=\"all\"  /><label for=\"all\" style=\"width: 0px;\"></label>");
                 //s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.nome,f.cognome,f.login,c.nome,c.cognome,c.login
            $righe=array();
            while($s=mysql_fetch_row($scambi))
                {
                $righe[]=array("$s[6] $s[7] ($s[8]) ","$s[9] $s[10] ($s[11])",$s[3] ,$s[4],$s[5],"<input type=\"checkbox\" class=\"filled-in\" name=\"check[]\" id=\"$s[0]\"value=\"$s[0]\"/><label for=\"$s[0]\" style=\"width: 0px;\"></label>");
                }
            $dim=array("20%","20%","20%","20%%","15%","5%");
            agg_tabella($intest, $righe, $dim, "scambi_da_confermare");
                ?>
     
            <script>$("table thead th:eq(6)").data("sorter", false);</script>
<?php /*
    <input name="cmd" type="submit" value="Conferma"></input>
    <input name="cmd" type="submit" value="Elimina"></input>
    <input name="cmd" type="reset" value="Reset"/>
    */?>
            <br/>
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Elimina">Elimina
    <i class="mdi-action-delete right"></i>
    </button>
            <script>
            $("#scambi_da_confermare").tablesorter({headers:{5:{sorter:false}}});
            </script>
    
</FORM>
<?php
}

else
{echo "Nessuno scambio da confermare!";}}	
require("../comuni/footer.php");?>


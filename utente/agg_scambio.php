<?php
require("../comuni/lib.php");
autentica(UTENTE);
$titolo="Aggiunta nuovo scambio";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{
	
	$fornitore=$_SESSION['id'];
	
	$cliente=  mysql_real_escape_string($_REQUEST['cliente']);
	preg_match('/\((.*?)\)/', $cliente, $match);
	$cliente=login_to_id($match[1]);
        $ore=  floatval($_REQUEST['ore']);
        $data=$_REQUEST['data'];
       // echo $data;
        $descrizione=trim(mysql_real_escape_string($_REQUEST['descrizione']));
        $c=split("\.",mysql_real_escape_string($_REQUEST['cat']));
        $cat=$c[0];
        $sub=$c[1];
        $explain=explain_cat($cat, $sub) ;
        $descrizione=trim(mysql_real_escape_string( $explain[0]."-".$explain[1]."  ---  ".$descrizione));
        $id=agg_scambio($fornitore,$cliente,$ore,$data,$descrizione);
        //mail_a_cassieri("Nuovo scambio inserito", "C'è un nuovo scambio da confermare!");
       
        $oggetto="Nuovo scambio inserito ".$nomebdt;
        $testo="<html><body><h3>C&agrave; un nuovo scambio inserito da confermare!</h3><br/>Ciao.</body></html>";
//        $destinatari=array();//array per i destinatari
//        $cassieri=  cassieri();//indirizzi amministratori
//        while ($row = mysql_fetch_array($cassieri))
//        {
//            $destinatari[]=$row[0];
//        }
//        mailer_new_multipli_esposti($destinatari, $oggetto, $testo);
        mailer_new_cassieri($oggetto, $testo);
        header('Location: ../index.php' );	
	
}
else
{

$utenti=utenti();
?>
<br/>
<br/>
<form class="" method="POST" onsubmit="return check_data();">
     <div class="row">
        <div class="col s12">
            <label>Cliente</label>
            <select name="cliente" autocomplete=off class="browser-default">
                    <?php
                            while($r=mysql_fetch_row($utenti))
                            {	
                                    if($r[0]!=nome_utente($_SESSION['id']))
                                    { 
                                        echo "<option value=\"$r[0]\">$r[0]</option>\n";
                                    }
                                    
                            }
                    ?> 
            </select>
        </div>
     </div>
        <div class="row">
                <div class="col s6">
                    <label for="data">Data Prestazione: </label>
                    <input id="data" name="data" type=date min="2000-01-01" max="<?=  oggi();?>"/><br/>
               </div>
               <div class="col s6">
                    <LABEL for="ore">Ore: </LABEL>
                    <input name="ore" type=number min=0.5 max=10 step=0.5 value=0.5 /><br/>
               
                </div>
         
        </div>
    <div class="row">
        <div class="col s12">
            <label for="cat">Categoria:</label>
                <select name="cat" id="cat" onchange="check_abilita_altro2()" class="browser-default">
                     <?php printCategorie();?>
                </select>
        </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <textarea id="descrizione" name="descrizione" class="materialize-textarea" maxlength="250" required="true" ></textarea>
        <label for="descrizione">Descrizione</label>
      </div>
    </div>
    
    <div class="row">
        
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    </div>
</form>


<script>
        $(document).ready(function() {
        $('select').material_select();
      });
</script>





<?php
}
require("../comuni/footer.php");

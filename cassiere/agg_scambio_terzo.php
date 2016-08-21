<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Aggiunta scambio";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{
	
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
    $c=split("\.",mysql_real_escape_string($_REQUEST['cat']));
    $cat=$c[0];
    $sub=$c[1];
    $explain=explain_cat($cat, $sub) ;
    $descrizione= $explain[0]."-".$explain[1]."  ---  ".$descrizione;
	
	$id=agg_scambio($fornitore,$cliente,$ore,$data,$descrizione);
	if(isset($_REQUEST['conferma']))
		scambio_confermato($id);
	header('Location: ./agg_scambio_terzo.php' );	
	}
}
else
{

$utenti=utenti();
?>
<FORM action="" method="POST" onsubmit="return check_data();">
	<P>
<div class="row">
<div class="col s6">
<label>Cliente</label>
<select name="cliente" autocomplete=off class="browser-default">
<?php
    while($r=mysql_fetch_row($utenti))
    {	

          ?>  <option value="<?=$r[0]?>"><?=$r[0]?></option> <?php

    }
?>
</select>
</div>
<div class="col s6">
<label>Fornitore</label>
<select name="fornitore" autocomplete=off class="browser-default">

<?php
mysql_data_seek($utenti, 0);
	while($r=mysql_fetch_row($utenti))
	{	
		
              ?>  <option value="<?=$r[0]?>"><?=$r[0]?></option> <?php
  		
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
      <input type="checkbox" name=conferma id="conferma" checked />
      <label for="conferma">Confermato?</label><br/><br/>
    <div class="row">
        
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    </div>
</P>
</FORM>

<?php
}
require("../comuni/footer.php");
?>



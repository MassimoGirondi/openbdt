<?php
require("../comuni/lib.php");
autentica(UTENTE);
$titolo="Modifica dati personali";
require("../comuni/header.php");
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
		
	// ----- Inserimento record nella tab. "users" -----
	$mail = trim(mysql_real_escape_string($_REQUEST['mail']));
        $cellulare =trim(mysql_real_escape_string($_REQUEST['cellulare']));
	$id=trim(mysql_real_escape_string($_SESSION['id']));
        $id_da_mail=  check_mail_2($mail);
        if($id==$id_da_mail || $id_da_mail==null)
        {
            $ris=mod_dati($id,$mail,$cellulare);
        }
        header('Location: ./mod_dati.php' );	
	}
	else
	{
        $id=$_SESSION['id'];
        $sql="SELECT mail,cellulare,data_rinnovo FROM users WHERE id = $id";
        $ris=mysql_safe_query($sql);
        $ris=mysql_fetch_row($ris);
        $mail = $ris[0];
        $cellulare =$ris[1];
        $data=$ris[2];
?>
<h5><?=stampa_data_bis($data)?></h5>
<br/>
<!--form-->
<form class="" method="POST" >
    
<div class="row">
<div class="col s10 m5">
  <div class="card blue-grey darken-1">
    <div class="card-content white-text">
      <span class="card-title">Modifica dei dati personali</span>
    <div class="row">
    <div class="input-field col s5">
      <input value="<?=$mail?>" id="mail" type="email" name=mail class="validate">
      <label class="active" for="mail">Email</label>
    </div>
    <div class="input-field col s5">
      <input value="<?=$cellulare?>" id="cellulare" type="number" name=cellulare class="validate" required min=1 max=999999999999 >
      <label class="active" for="cellulare">Cellulare</label>
    </div>
    </div>
    </div>
    <div class="card-action">
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
        
        
    </div>
  </div>
</div>
<!--/div--!>
</form>



<?php
/*

<fieldset style="width: 45%;">
<legend>Modifica dati personali</legend>
	<FORM action="" method="POST" >
	<P>
		
		<LABEL for="email">Indirizzo mail: </LABEL>
			<INPUT type="email" name="mail" autocomplete="off" value="<?=$mail?>" />
		<br/>
		<LABEL for="cellulare">Cellulare/telefono: </LABEL>
			<INPUT type="number" name="cellulare" autocomplete="off" value="<?=$cellulare?>"  required min=1 max=999999999999 />
		<br/>

		
		<input type="hidden" name="id" value="<?=$id?>">
		<input name="cmd" type="submit" value="Conferma" />
  		<input name="cmd" type="reset" value="Reset" />
	</P>
	
</FORM>
*/?>

<form action="mod_psw.php" method="POST" onsubmit="return testpass(this)" >
    
<!--<div class="row">!-->
<div class="col s12 m6">
  <div class="card blue-grey darken-1">
    <div class="card-content white-text">
      <span class="card-title">Modifica password</span>
    <div class="row">
    <div class="input-field col s6">
      <input id="password1" type="password" name=password1 class="validate" required autocomplete="off">
      <label class="active" for="passsword1">Nuova password</label>
    </div>
    <div class="input-field col s6">
      <input id="password2" type="password" name=password2 class="validate" required autocomplete="off">
      <label class="active" for="password2">Reinserisci</label>
    </div>    
    </div>
    </div>
    <div class="card-action">
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
        
        
    </div>
  </div>
</div>
</div>
</form>

<?php /*
</fieldset>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<fieldset style="width: 45%;"> 
<legend>Modifica Password</legend>
    


<FORM action="mod_psw.php" method="POST" onsubmit="return testpass(this)" >
	<P>
		
		<LABEL for="password1">Nuova password: </LABEL>
			<INPUT type="password" name="password1" autocomplete="off" required/>
		<br/>
		<LABEL for="password2">Reinserisci: </LABEL>
			<INPUT type="password" name="password2" autocomplete="off" required/>
		<br/>
		
		<input name="cmd" type="submit" value="Conferma" />
  		<input name="cmd" type="reset" value="Reset" />
	</P>
	
</FORM>	
</fieldset>

*/
?>
 


<!--
      <div class="row">
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Gestione abilit&agrave;</span>
              <p>-->
<h4>Gestione abilit&agrave;</h4>
                  <?php require ("./mie_abilita.php"); ?></p>
<!--
            </div>
          </div>
        </div>
      </div>
-->
<?php /*
<fieldset>
    <legend>Gestione abilit&agrave;</legend>
    <?php require ("./mie_abilita.php"); ?>
</fieldset>

<?php */
}
require("../comuni/footer.php");
?>



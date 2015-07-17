<?php
require("../comuni/lib.php");
autentica(ADMIN);
$titolo="Modifica dati utente";
require("../comuni/header.php");
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
		
	// ----- Inserimento record nella tab. "users" -----
	$mail = trim($_REQUEST['mail']);
	$cellulare =trim($_REQUEST['cellulare']);
	$privilegi = $_REQUEST['privilegi'];
	$id=$_REQUEST['id'];
	$ris=mod_utente($id,$mail,$cellulare,$privilegi);
        
        $old=$_REQUEST['old_priv'];
        if($old==DISABILITATO && $privilegi>DISABILITATO && $mail!=null && mail!="")
        {
            $a=$mail;
            $oggetto="Iscrizione ".$nomebdt;
            $testo="<html><body>Ciao, il tuo account &egrave; stato approvato.";
            $testo.="Queste sono le credenziali per l'accesso:<br/>\n"
		    .credenziali_mail($id)."\n"
                    . "<br/><a href=\"$home\">"
                . "Clicca qui per andare sul sito</a></body></html>";
            mailer_new($a, $oggetto, $testo);
//invia_mail($a,$oggetto,$messaggio);
        }
        
        
	echo "Hai modificato con successo l'utente(ID:".$ris." )!";
	header('Location: ./elenco.php' );	
	}
	else
	{
		$id=$_REQUEST['id'];
		$sql="SELECT id,login,nome,cognome,mail,cellulare,priv FROM users WHERE id = $id";
		$ris=mysql_safe_query($sql);
		$ris=mysql_fetch_row($ris);
		$login=$ris[1];
		$nome = $ris[2];
		$cognome = $ris[3];
		$mail = $ris[4];
		$cellulare =$ris[5];
		$password ="121212121";//la password non può essere modificata da qui (salvata come md5)
		$privilegi = $ris[6];

?>

<!--form-->
	<FORM action="" method="POST" class="s12">
	<div class=row>
            <div class="input-field col s6">
		<LABEL for="nome">Nome: </LABEL>
		<INPUT type="text" name="nome" autocomplete="off" value= "<?=$nome?>" required disabled/>
            </div>
        </div>
        <div class=row>
            <div class="input-field col s6">
		<LABEL for="cognome">Cognome: </LABEL>
		<INPUT type="text" name="cognome" autocomplete="off" value="<?=$cognome?>" required disabled/>
            </div>
        </div>  
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="login">Username: </LABEL>
		<INPUT type="text" name="login" autocomplete="off" value="<?=$login?>"   required disabled/>
		<br/>
            </div>
        </div>  
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="email">Indirizzo mail: </LABEL>
		<INPUT type="email" name="mail" autocomplete="off" value="<?=$mail?>"/>
            </div>
        </div> 
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="cellulare">Cellulare/telefono: </LABEL>
		<INPUT type="tel" name="cellulare" autocomplete="off" value="<?=$cellulare?>"  required/>
            </div>
        </div> 
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="password">Password: </LABEL>
		<INPUT type="password" name="password" autocomplete="off" value="<?=$password?>"  disabled /> Per modificare la password usare l'apposita pagina
            </div>
        </div> 

        <input name="privilegi" class="with-gap" type="radio" id="priv1" value="<?=DISABILITATO?>" <? if($privilegi == DISABILITATO) echo "checked";?> />    
        <label for="priv1">Disabilitato</label>

        <br/>
        <input name="privilegi" class="with-gap"  type="radio" id="priv2" value="<?=UTENTE?>" <? if($privilegi == UTENTE) echo "checked";?> />    
        <label for="priv2">Utente</label>

        <br/>
        <input name="privilegi" class="with-gap"  type="radio" id="priv3" value="<?=CASSIERE?>" <? if($privilegi == CASSIERE) echo "checked";?> />    
        <label for="priv3">Cassiere</label>

        <br/>
        <input name="privilegi" class="with-gap" type="radio" id="priv4" value="<?=ADMIN?>" <? if($privilegi == ADMIN) echo "checked";?> />    
        <label for="priv4">Admin</label>
        <br/>

        <input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="old_priv" value="<?=$privilegi?>">
        
    <div class="row">
        
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    </div>
	
</FORM>

<?php
}
require("../comuni/footer.php");
?>



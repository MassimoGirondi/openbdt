<?php
require("../comuni/lib.php");
autentica(ADMIN);
$titolo="Aggiunta nuovo utente";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) {
		
	// ----- Inserimento record nella tab. "users" -----
	
	$nome = addslashes($_REQUEST['nome']);
	$cognome = addslashes($_REQUEST['cognome']);
	$login= login_fix($nome,$cognome);
	$email = trim($_REQUEST['email']);
	$cellulare =$_REQUEST['cellulare'];
	$password =$_REQUEST['password'];
	$privilegi = $_REQUEST['privilegi'];
        $cf= $_REQUEST['privilegi'];
	$ris=agg_utente($nome,$cognome,$login,$email,$cellulare,$password,$privilegi,$cf);
        if($a!=null && a!="")
        {
        $a=$email;
        $oggetto="Iscrizione ".$nomebdt;
        $messaggio="Ciao, sei stato iscritto al sito ".$sito.".";
        $messaggio.="Queste sono le credenziali per l'accesso:"
                . "\nUtente: $login\nPassword: $password"
                . "Il sito &egrave; raggiungibile all'indirizzo "
                . "<a href=\"$home\">$home</a>";
	//invia_mail($a,$oggetto,$messaggio);
        mailer_new($a, $oggetto, $messaggio);
        }
	echo "Hai creato con successo il nuovo utente(ID:".$ris." con login ".$login." )!";
	header('Location: ./elenco.php' );	
	}
	else
	{
?>

<!--form-->
<FORM action="" class="s12" method="POST" onsubmit="return check_cf()">
    <input style="display:none">
<input type="password" style="display:none">
<div class=row>
            <div class="input-field col s6">
		<LABEL for="nome">Nome: </LABEL>
		<INPUT type="text" name="nome" autocomplete="off" required />
            </div>
        </div>
        <div class=row>
            <div class="input-field col s6">
		<LABEL for="cognome">Cognome: </LABEL>
		<INPUT type="text" name="cognome" autocomplete="off" required />
            </div>
        </div>  
        <div class=row>
            <div class="input-field col s6">
            <LABEL for="cf">Codice fiscale </LABEL>
		<INPUT type="text" name="cf" id="cf" autocomplete="off"  required/>
            </div></div>
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="email">Indirizzo mail: </LABEL>
		<INPUT type="email" name="mail" autocomplete="off"/>
            </div>
        </div> 
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="cellulare">Cellulare/telefono: </LABEL>
		<INPUT type="tel" name="cellulare" autocomplete="off"  required/>
            </div>
        </div> 
            <div class=row>
            <div class="input-field col s6">
		<LABEL for="password">Password: </LABEL>
		<INPUT type="password" name="password" autocomplete="off" reuquired /> 
            </div>
        </div> 

        <input name="privilegi" class="with-gap" type="radio" id="priv1" value="<?=DISABILITATO?>"/>    
        <label for="priv1">Disabilitato</label>

        <br/>
        <input name="privilegi" class="with-gap"  type="radio" id="priv2" value="<?=UTENTE?>" checked/>    
        <label for="priv2">Utente</label>

        <br/>
        <input name="privilegi" class="with-gap"  type="radio" id="priv3" value="<?=CASSIERE?>" />    
        <label for="priv3">Cassiere</label>

        <br/>
        <input name="privilegi" class="with-gap" type="radio" id="priv4" value="<?=ADMIN?>" />    
        <label for="priv4">Admin</label>
        <br/>	

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



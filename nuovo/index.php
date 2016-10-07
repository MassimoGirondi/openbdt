<?php
require("../comuni/lib.php");
require_once ("../comuni/recaptchalib.php");
dbconnect();
$ok=false;
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd']=="Conferma")) {
    $resp = null;
    $error = null;
    $reCaptcha = new ReCaptcha($chiavesegreta);
    if ($_POST["g-recaptcha-response"]) {
        $resp = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }
    if ($resp != null && $resp->success) {
        
    
    
$cf= strtoupper( $_REQUEST["cf"]);
$mail=  isset($_REQUEST['email'])? mysql_real_escape_string($_REQUEST['email']) : "";
if(check_cf($cf) && check_mail($mail))
{
$nome=mysql_real_escape_string($_REQUEST['nome']);
$cognome=mysql_real_escape_string($_REQUEST['cognome']);

$email=  isset($_REQUEST['email'])? mysql_real_escape_string($_REQUEST['email']) : "";
$indirizzo=mysql_real_escape_string($_REQUEST['indirizzo']);
$cellulare=mysql_real_escape_string($_REQUEST['cellulare']);
$password=mysql_real_escape_string($_REQUEST['password1']);
$login=  login_fix($nome, $cognome);
$cf=  strtoupper( $_REQUEST["cf"]);


$oggetto="Nuovo Iscritto ".$nomebdt;
$testo="<html><body><h3>C&agrave; del lavoro per te!</h3><br/>\nNome: ".$nome."<br/>\nCognome: ".$cognome."<br/>\nEmail: ".$email."\n<br/>Indirizzo: ".$indirizzo."<br/>\ncellulare: ".$cellulare."<br/>\nFatica!!</body></html>";
//mail_a_admins($oggetto, $messaggio);

$destinatari=array();//array per i destinatari
$admins=admins();//indirizzi amministratori
//while ($row = mysql_fetch_array($admins))
//{
//    $destinatari[]=$row[0];
//}
//mailer_new_multipli_esposti($destinatari, $oggetto, $testo);
            mailer_new_admins($oggetto, $testo);
$ok=true;
}
else
{
    ?>
<script>
    alert("Codice fiscale o mail gi‡ presente!");
    window.history.back();
</script>
<?php
}
    }
    else
    {
        ?><script>
    alert("Completa il test di sicurezza!");
    window.history.back();
   
</script>
    <?php
    } 
}//qui finisce l'iscrizione

?>
<html>
<head><title>Richiesta iscrizione</title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <link href="../comuni/bdt.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../comuni/jquery.js"></script>
        <script type="text/javascript" src="../comuni/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="../comuni/lib.js"></script>
        
        <link type="text/css" rel="stylesheet" href="../comuni/materialize/css/materialize.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <script type="text/javascript" src="../comuni/materialize/js/materialize.min.js"></script>
<body>
<div class="intestazione">
            <img class="logo" src="../comuni/logo.png"> </img>
            <div class="titolo"><?=$nomebdt?></div>
		
	</div>
    <h1>Richiesta iscrizione</h1>
<?php if(!$ok){?>
Compilando il modulo sottostante richiederai di avere accesso al sito <?=$sito;?>, riceverai un'email  quando verrai abilitato (<b>controlla che non finisca nello spam</b>).
<hr/>
<form action="" method="POST" onsubmit="return testpass(this) && check_cf()">
	<div class="row s12">
             <div class="input-field col s6">
		<label for="nome">Nome: </label>
			<input type="text" name="nome" required maxlength="20"/>
		<br/>
             </div>
            <div class="input-field col s6">
		<label for="cognome">Cognome: </label>
			<input type="text" name="cognome" required maxlength="20"/>
            </div>
        </div>
        <div class="row s12">
             <div class="input-field col s6">
		<label for="email">Indirizzo mail: </label>
			<input type="email" name="email" maxlength="50"/> Non Ë obbligatoria, ma per il funzionamento ottimale dell'applicazione &egrave; consigliato inserirla.
             </div>
            <div class="input-field col s6">
		<label for="cellulare">Cellulare/telefono: </label>
			<input type="number" min=1 max=99999999999999 name="cellulare" required/>
            </div>
        </div>
        <div class="row s12">
            <div class="input-field col s6">
		<label for="indirizzo">Indirizzo: </label>
			<input type="text" name="indirizzo" required maxlength="75"/>
             </div>
            <div class="input-field col s6">
                    <label for="password">Codice Fiscale: </label>
                    <input type="text" name="cf" id='cf'  required/>
            </div>
        </div>
        <div class="row s12">
          <div class="input-field col s6">
		<label for="password">Password: </label>
			<input type="password" name="password1" autocomplete="off"  required/>
             </div>
            <div class="input-field col s6">
		<label for="password">Conferma password: </label>
			<input type="password" name="password2" autocomplete="off"  required/>
            </div>
        </div>
	<div class="row s12">
		Premendo conferma accossentirai che i tuoi dati vengano trattati nel rispetto della privacy da <?=$nomebdt;?>,
        con la possibilit&agrave; che alcuni tuoi dati siano diffusi all'interno del gruppo per comunicazioni interpersonali
        relative esclusivamente all'attivit&agrave; <?=$sito;?>.<br/>
        Ti assumi la responsabilit&agrave; di non diffondere dati sensibili che vedrai all'interno del sito all'esterno,
        non comunicandoli a terzi e di non sfruttarli a fini non inderenti la Banca del Tempo.<br/>
        
        Ti assumi, inoltre, la responsabilit&agrave; di aver fornito false generalit&agrave; e accetti il <a href="../documenti/regolamento.pdf" target="_blank">regolamento </a>
        </div>
		
        
    <hr/>
        <div>
        <b/>Autorizzazione al trattamento dei dati personali</b><br/>
        Definizione di dati personali:<br>
        Sono considerati dati personali (a titolo esemplificativo ma non esaustivo) 
        il nome, il telefono, la mail e tutti i dati raccolti in forma non anonima dal sito
        a seguito dell'attivit&agrave; dell'utente su di esso. 
        Questi dati non verranno in nessun caso diffusi in rete o ceduti a terzi,
        fatti salvi eventuali obblighi di legge e necessit&agrave; tecniche legate all'erogazione del servizio.
        Essendo la Banca del Tempo per sua stessa natura una rete sociale dedicata alla collaborazione di tutti gli iscritti,
        &egrave; prevista la visibilit&agrave; dei dati personali (tutti o una parte di essi) da parte degli altri utenti alla Banca,
        al fine di poter comunicare fra i vari membri e poter offrire/richiedere "scambi".
        Il proprio indirizzo mail e cellulare potr&agrave; essere trasmesso all'Associazione Famiglie Insieme ONLUS per 
        comunicazioni inerenti l'attivit√† di volontariato.
        Il responsabile del trattamento dei dati &egrave; il presidente dell'associazione Famiglie Insieme ONLUS,
        con sede presso Via G. Matteotti 1 Isola Vicentina.
        Il trattamento sar&agrave; realizzato con l'ausilio di strumenti informatici da parte della Banca del Tempo
        e degli operatori scelti in assemblea da quest'ultima.
        In qualsiasi momento sar&agrave; possibile richiedere gratuitamente la verifica, la cancellazione,
        la modifica dei propri dati, o ricevere l'elenco degli incaricati del trattamento inviando una email a <a href="mailto:<?=$infomail?>"><?=$infomail?></a>.
        
            
        </div>
        <hr/>
                
            <div class="g-recaptcha" data-sitekey="<?php echo $chiavesito;?>"></div>
    <script type="text/javascript"
          src="https://www.google.com/recaptcha/api.js?hl=<?=$lingua;?>">
    </script>
                    <div class="row">
        
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    </div>
                
    <br/>

</div>
	
</form>
<?php } 
else
{
	echo "<h2>Stampa questa pagina e consegnala alla prossima riunione,<br/>"
    . " servir&agrave; per pagare la quota e farti abilitare il tuo utente.</h2>";
        $sql="SELECT id,data_rinnovo,login FROM users WHERE nome='$nome' AND cognome='$cognome' AND mail='$email' ORDER BY data_rinnovo DESC";
        $ris=  mysql_fetch_row(mysql_safe_query($sql));
        ?>
        Nome: <?=$nome;?><br/>
        Cognome: <?=$cognome;?><br/>
        Email: <?=$email;?><br/>
        Cellulare: <?=$cellulare;?><br/>
        Data: <?=$ris[1];?><br/>
        ID: <?=$ris[0];?><br/>
        Login: <?=$ris[2]?><br/>
        <button onclick="window.print();">Stampa</button>
    <?php
}
    ?>

<?php
/*
<script type="text/javascript">
 
function testpass(modulo){
  // Verifico che il campo password sia valorizzato in caso contrario
  // avverto dell'errore tramite un Alert
  if (modulo.password1.value == ""){
    alert("Errore: inserire una password!")
    modulo.password1.focus()
    return false
  }
  // Verifico che le due password siano uguali, in caso contrario avverto
  // dell'errore con un Alert
  if (modulo.password1.value != modulo.password2.value) {
    alert("Le due password non coincidono!")
    modulo.password1.focus()
    modulo.password1.select()
    return false
  }
  return true
}
function check_cf()
{
//    return true;
    
    var d=document.getElementById("cf").value;
    var reg=new RegExp("[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]");

    var a= reg.test(d);
    if(!a)
        alert("Formato Codice Fiscale errato!");
   // alert(document.getElementById("data").value);
    return a;
}

 </script>*/
?>
</body>
</html>

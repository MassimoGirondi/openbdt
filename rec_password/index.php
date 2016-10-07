<?php 
require_once("../comuni/lib.php");
require_once ("../comuni/recaptchalib.php");?>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <link href="../comuni/bdt.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../comuni/jquery.js"></script>
        <script type="text/javascript" src="../comuni/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="../comuni/lib.js"></script>
        
        <link type="text/css" rel="stylesheet" href="../comuni/materialize/css/materialize.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <script type="text/javascript" src="../comuni/materialize/js/materialize.min.js"></script>
        <title>
		<?php echo $nomebdt;?>-Recupero password
	</title>

        
    </head>
    <body>
        
        <div class="intestazione">
            <img class="logo" src="../comuni/logo.png"> </img>
            <div class="titolo"><?=$nomebdt?></div>
	</div>
<?php


if(isset($_REQUEST['mail'])&&isset($_REQUEST['con_mail']))
{
    dbconnect();
    $email=trim(mysql_real_escape_string($_REQUEST['mail']));
        
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
        
    

    if(cerca_mail($email))
    {
        //allora mando la mail con la password
        $password=  password_random(10);
        $id=  mail_to_id($email);
	//echo "password generata<br>";        
	$txt="<html><body>"
                . "Ciao, hai chiesto di cambiare la password del tuo account sul sito $sito."
                . "<br/>La tua nuova password &egrave;: $password"
                . "<br/>Il tuo nome utente &egrave;: ".  id_to_user($id)
                . "<br/>Ti consigliamo di cambiare la password alla prima occasione e di scrivertela in un posto sicuro."
                . "<br/><a href=\"$home\">"
                . "Clicca qui per andare sul sito</a></body></html>";
        
//echo $id;
        cambia_password($id, $password);
	//echo "password modificata<br>";   
//        invia_mail($email, "$nomebdt-Recupero password", $txt);

            mailer_new($email, "$nomebdt - Cambio password", $txt);
        //echo "mail inviata<br>"; 
        ?>
        <script>
            alert("Ti abbiamo inviato una mail con la tua nuova password");
            window.location.replace("<?=$home?>");
        </script>
            <?php
    }
    else
    {
        ?>
        <script>
            alert("Mail non trovata!");
            window.history.back();
        </script>
            <?php
    }
}
else
{
    ?>
        <script>
            alert("Completa il test di sicurezza!!");
            window.history.back();
        </script>
            <?php
}
}

else if(isset($_REQUEST['user'])&&isset($_REQUEST['senza_mail']))
{
    
    dbconnect();
    $user=trim(mysql_real_escape_string($_REQUEST['user']));
        
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
        
    

    if($utente=cerca_user($user))
    {
        //allora mando la mail all'admin
        $password=  password_random(10);
	//echo "password generata<br>";        
	$txt="<html><body>"
                . "Ciao, $utente[1] $utente[2] ($utente[3])ha chiesto di cambiare la password sul sito $sito."
                . "<br/>Sei pregato di metterti in contatto con lui/lei, il suo numero di telefono &egrave; $utente[4]"
                . "<br/><a href=\"$home\">"
                . "Clicca qui per andare sul sito</a></body></html>";
        
//echo $id;
        //cambia_password($id, $password);
	//echo "password modificata<br>";   
       
         //mail_a_admins($oggetto, $messaggio);
        $oggetto="Cambio password ".$nomebdt;
//        $destinatari=array();//array per i destinatari
//        $admins=admins();//indirizzi amministratori
//        while ($row = mysql_fetch_array($admins))
//        {
//            $destinatari[]=$row[0];
//        }
//        mailer_new_multipli_esposti($destinatari, $oggetto, $txt);
        //echo "mail inviata<br>"; 
        mailer_new_admins($oggetto, $txt);
        ?>
        <script>
            alert("Amministratore contattato, ora devi attendere che ti chiami.\nBuona giornata");
            window.location.replace("<?=$home?>");
        </script>
            <?php
    }
    else
    {
        ?>
        <script>
            alert("User non trovato!");
            window.history.back();
        </script>
            <?php
    }
}
else
{
    ?>
        <script>
            alert("Completa il test di sicurezza!!");
            window.history.back();
        </script>
            <?php
}
    
    
    
}






?>
        
    <form method="POST">
    Test di sicurezza:<br/>
    <div class="g-recaptcha" data-sitekey="<?php echo $chiavesito;?>"></div>
    <script type="text/javascript"
          src="https://www.google.com/recaptcha/api.js?hl=<?=$lingua;?>">
    </script><br/>
    Completa il test di sicurezza, quindi scegli uno dei passaggi successivi.<br/>
    <fieldset>
    Se ti sei registrato mediante e-mail, inseriscila nel box sottostante, riceverai la nuova password per e-mail<br/>
    <input type="email" name="mail"/>
    <button class="btn waves-effect waves-light" type="submit" name="con_mail" value="Recupera">Recupera
    <i class="mdi-content-send right"></i>
    </button>
    </fieldset><br/>
    <br/>
    <fieldset>
    Altrimenti inserisci il tuo nome utente nel box sottostante, 
    un amministratore ti contatter&agrave; al pi&ugrave; presto<br/>
    <input type="text" name="user"/>
        <button class="btn waves-effect waves-light" type="submit" name="senza_mail" value="Recupera">Recupera
    <i class="mdi-content-send right"></i>
    </button>
    </form>
    </fieldset>       
        </form>
        
    <?php

require("../comuni/footer.php");




<?php
require("../comuni/lib.php");
autentica(UTENTE);
$titolo="Segnala Bug";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{
	
	$desc=trim(mysql_real_escape_string($_REQUEST['descrizione']));
        if($desc!=null && $desc!="")
        {
        $id=$_SESSION['id'];
	agg_bug($id,$desc);
        //mail_a_admins("Nuovo bug segnalato", "Nuova segnalazione:\n".$desc);
        $destinatari=array();//array per i destinatari
        $admins=admins();//indirizzi amministratori
        while ($row = mysql_fetch_array($admins))
        {
            $destinatari[]=$row[0];
        }
        mailer_new_multipli_esposti($destinatari, "Nuovo bug segnalato", "Controlla cos'&egrave; stato srgnlato.<br/>ciao");	
        }
        header('Location: ../index.php' );
}
else
{

?>
<FORM action="" method="POST">
<H3>Compila il campo qui sotto, contribuirai a migliorare il sito</H3><br/>
<LABEL for="descrizione">Descrizione: </LABEL>
<textarea name="descrizione" maxlength="250"></textarea><br/>
<input name="cmd" type="submit" value="Conferma" />
</P>
</FORM>


<?php
}
require("../comuni/footer.php");

<?php
require("./comuni/lib.php");
dbconnect();

session_start(); // inizializzo la sessione
if (isset($_SESSION["id"]) && ($_SESSION["id"]!=0))
{
    /* se l'utente è già loggato viene reindirizzato per continuare la sua sessione */
    header('Location: comuni/loggato.php');
}

if (isset($_POST["submit"]) && ($_POST["submit"]=="ENTRA"))
{
    if(!(isset($_REQUEST['jscheck']) && $_REQUEST['jscheck']=="yes"))
    {
        ?>
        Devi abilitare Javascript per visualizzare questo sito!
        <a href="./login.php" >Clicca qui per tornare alla pagina di login</a>
        <?php
                exit();
    }
	$username=trim(addslashes($_POST["login"])); /* evito SQL-Injection */
	$password=trim(addslashes($_POST["password"]));
	$id=login($username,$password);
        if($id<0)
        {//allora ho un errore
            //login_error($id);
            //login_form();
            //require("./login.php?e=".$id);
            header('Location: login.php?e='.$id);
        }
        else
        {
            //login effettuato
            $_SESSION["login"]=$username;
            $_SESSION["id"]=$id;
            $_SESSION["priv"]=id_to_priv($id);

    //		$_SESSION["saldo"]=id_to_saldo($id);
    //		echo "sei ".$login;
            header('Location: ./comuni/loggato.php');
        }

}
else
     require("./login.php");
	//login_form();
?>

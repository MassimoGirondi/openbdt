<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Modifica abilit&agrave;";
require("../comuni/header.php");
$mod=isset($_REQUEST['mod'])&&$_REQUEST['mod']!=-100;//se ho un parametro mod allora voglio modificare un record già presente
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma") && $mod)
{ //dopo aver premuto invia per la modifica
        $id=$_REQUEST['id'];
        $c=split("\.",$_REQUEST['cat']);
        $cat=$c[0];
        $sub=$c[1];
        $note=$_REQUEST['note'];
        mod_abilita_cassiere($id, $cat, $sub, $note);
	header('Location: ./tutte_abilita.php' );	
}
else
{
    if(isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma"))
    {//ne ho inserito uno nuovo
        $uid=$_REQUEST['user'];
        $c=split("\.",$_REQUEST['cat']);
        $cat=$c[0];
        $sub=$c[1];
        $note=$_REQUEST['note'];
        agg_abilita($uid, $cat, $sub, $note);
	header('Location: ./tutte_abilita.php' );
    }
    else//devo mostrare il form
    {
        if($mod)
        {
            //carico i dati nella form per la modifica
            $id_abi=$_REQUEST['mod'];
            $abilita=  abilita_by_id($id_abi);
            $c=$abilita[2];
            $s=$abilita[3];
            $note=$abilita[4];
            $uid=$abilita[1];
        }
        else
        {//dichiaro le variabili(non le uso ma senno mi darebbe errore)
            $id_abi=0;
            $c=1;
            $s=1;
            $note="";
            $uid=0;
            
        }
        
     
?>
<FORM action="" method="POST" >
	<P>
<LABEL for="user">Utente: </LABEL>
<SELECT name="user" <?=$mod?"disabled":""?>>
    <?php print_utenti_selected($uid);?>
</SELECT>
<br/>             
<LABEL for="cat">Categoria: </LABEL>
<SELECT name="cat" id="cat" onchange="check_abilita_altro()">
    <?php printCategorie_selected($c,$s);?>
</SELECT>
<br/> 
<LABEL for="note">Note/descrizione:</LABEL>
<TEXTAREA name="note" id="note" maxlength="150"><?php echo $note;?></TEXTAREA>
<?php
/*
<?=$mod?"<input name=user type=hidden value=$uid":""?>*/
?>
<input name=id type=hidden value=<?=$id_abi?>>
<input name=mod type=hidden value=<?=$mod?$mod:-100?>><br/>
<input name="cmd" type="submit" value="Conferma" />
<input name="cmd" type="reset" value="Reset" />
</P>
</FORM>

<?php
}
}
require("../comuni/footer.php");

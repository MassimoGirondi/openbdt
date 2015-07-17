<?php
require("../comuni/lib.php");
autentica(UTENTE);
$titolo="Modifica abilit&agrave;";
require("../comuni/header.php");
$mod=isset($_REQUEST['mod'])&&$_REQUEST['mod']!=-100;//se ho un parametro mod allora voglio modificare un record già presente
if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma") && $mod) //dopo aver premuto invia per la modifica
{
        $uid=$_SESSION['id'];
        $id=  mysql_real_escape_string($_REQUEST['id']);
        $c=split("\.",mysql_real_escape_string($_REQUEST['cat']));
        $cat=$c[0];
        $sub=$c[1];
        $note=mysql_real_escape_string($_REQUEST['note']);
        mod_abilita($uid, $id, $cat, $sub, $note);
	header('Location: ./mod_dati.php' );	
}
else
{
    if(isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma"))
    {//ne ho inserito uno nuovo
        $uid=$_SESSION['id'];
        $c=split("\.",mysql_real_escape_string($_REQUEST['cat']));
        $cat=$c[0];
        $sub=$c[1];
        $note=mysql_real_escape_string($_REQUEST['note']);
        agg_abilita($uid, $cat, $sub, $note);
	header('Location: ./mod_dati.php' );
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
        }
        else
        {//dichiaro le variabili(non le uso ma senno mi darebbe errore)
            $id_abi=0;
            $c=1;
            $s=1;
            $note="";
            
        }
        
  /*   
?>
<FORM action="" method="POST" >
	<P>
<LABEL for="cat">Categoria: </LABEL>
<SELECT name="cat" id="cat" onchange="check_abilita_altro()">
    <?php printCategorie_selected($c,$s);?>
</SELECT>
<br/> 
<LABEL for="note">Note/descrizione:</LABEL>
<TEXTAREA name="note" id="note" maxlength="150"><?php echo $note;?></TEXTAREA>
<input name=id type=hidden value=<?=$id_abi?>>
<input name=mod type=hidden value=<?=$mod?$mod:-100?>><br/>
<input name="cmd" type="submit" value="Conferma" />
<input name="cmd" type="reset" value="Reset" />
</P>
</FORM>
*/?>

<form class="" method="POST">
     <div class="row">
        <div class="col s12">
            <label>Categoria</label>
            <select name="cat" id="cat" onchange="check_abilita_altro()" class="browser-default">
                <?php printCategorie_selected($c,$s);?>
            </select>
        </div>
     </div>
    <div class="row">
      <div class="input-field col s12">
        <textarea id="note" name=note class="materialize-textarea" maxlength="150"><?php echo $note;?></textarea>
        <label for="note">Note/descrizione</label>
      </div>
    </div>
    
    <div class="row">
        
<input name=id type=hidden value=<?=$id_abi?>>
<input name=mod type=hidden value=<?=$mod?$mod:-100?>><br/>
        
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    </div>
</form>

<?php
}
}
require("../comuni/footer.php");

<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Aggiunta sottocategoria";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{
$cat=  mysql_real_escape_string($_REQUEST['cat']);
$desc=mysql_real_escape_string($_REQUEST['nome']);
agg_subcategoria($cat, $desc);
mail_a_admins("AGGIUNTA SUBCATEGORIE", "OCIO, l'utente ".$_SESSION['Login']
        ."ha aggiunto la subcategoria $desc alla categoria n. $cat.");
}
?>
<h3>Stai per aggiungere una nuova sottocategoria</h3>
Attenzione!! Questa operazione pu&ograve; essere annullata soltanto dall'amministratore 
e potrebbe creare non pochi problemi.
Porsegui solo se sei certo di quello che stai per fare
N.B.: La categoria ALTRO richiede una descrizione obbligatoria!
<FORM action="" method="POST">
    <div class="row">
        <div class="col s12">
            <label for="cat">Categoria:</label>
                <select name="cat" id="cat" class="browser-default">
                     <?php printsoloCategorie();?>
                </select>
        </div>
    </div>
    <div class="row">
        
        <div class=row>
            <div class="input-field col s6">
		<LABEL for="nome">SubCategoria: </LABEL>
		<INPUT type="text" name="nome" autocomplete="off" required />
            </div>
        </div>
    <button class="btn waves-effect waves-light" type="submit" name="cmd" value="Conferma">Conferma
    <i class="mdi-content-send right"></i>
    </button>
    
    <button class="btn waves-effect waves-light" type="reset" name="cmd" value="Reset">Reset
    </button>
    </div>
</P>
</FORM>

<?php

require("../comuni/footer.php");
?>



<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Aggiunta sottocategoria";
require("../comuni/header.php");

if (isset($_REQUEST['cmd']) && ($_REQUEST['cmd'] == "Conferma")) 
{
$desc=mysql_real_escape_string($_REQUEST['nome']);
agg_categoria($desc);
mail_a_admins("AGGIUNTA CATEGORIE", "OCIO, l'utente ".$_SESSION['Login']
        ."ha aggiunto la categoria $desc");
}
?>
<h3>Stai per aggiungere una nuova categoria</h3>
Attenzione!! Questa operazione pu&ograve; essere annullata soltanto dall'amministratore 
e potrebbe creare non pochi problemi, anche molto gravi.
Porsegui solo se sei certo di quello che stai per fare
<FORM action="" method="POST">
        <div class=row>
            <div class="input-field col s6">
		<LABEL for="nome">Categoria: </LABEL>
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



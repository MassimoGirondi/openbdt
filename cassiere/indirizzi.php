<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo = "Report Indirizzi";
require("../comuni/header.php");

echo "<fieldset><legend>Copia il testo sottostante e incollalo nel campo <b>ccn</b></legend>";
echo indirizzi();
echo "</fieldset";
require("../comuni/footer.php");

?>


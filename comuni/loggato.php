<?php
require("lib.php");
autentica(UTENTE);
require("header.php");
//echo "Io sono il contenuto della home<br/>";
//echo "E tu sei ".$_SESSION["id"].", un ".priv_to_human($_SESSION["priv"] );
echo "<br/>".riepilogo($_SESSION["id"]);
//$annunci=ultimi_annunci();

?>
<h3>Finora sono state scambiate <?=ore_tot()?> ore</h3><br/>
Novit&agrave;! Premendo sulle intestazioni di una tabella si ordina.Puoi anche selezionare pi&ugrave; colonne tenendo premuto il tasto shift.
<?php /*<br/><a href="../../openbdt_legacy/comuni/loggato.php">Vuoi tornare alla vecchia versione? Clicca qui</a>*/?>
<br/><a href="../bug_reports/segnala.php">C'&egrave; qualcosa che non funziona? Hai trovato un errore o vuoi lasciare un suggerimento? Clicca qui</a>

<?php //<h1><a href="../comuni/debug.php">Premi qui per vedere il log di debug</a></h1>
require("footer.php");
?>
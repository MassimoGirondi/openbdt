<?php
require("../comuni/lib.php");
autentica(UTENTE);
dbconnect();
//$titolo="Dettagli attivit&agrave;";
//require("../comuni/header.php");
if(isset($_REQUEST['id']))
{
    $id=  mysql_real_escape_string($_REQUEST['id']);
    $dett=  dettagli_abilita($id);
    echo "Dettagli dell'abilità selezionata:\n";
    echo "Nome: $dett[1]\n";
    echo "Cognome: $dett[2]\n";
    echo "Username: $dett[0]\n";
    echo "Categoria: $dett[3]\n";
    echo "Sottocategoria: $dett[4]\n";
    echo "Note: $dett[5]\n";
    echo "Mail: $dett[6]\n";
    echo "Cellulare: $dett[7]\n";
    
}
else
    {echo "Errore!";}
    ?>
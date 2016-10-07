<?php      
require("../comuni/lib.php");
dbconnect();
autentica(ADMIN);
require ('../comuni/header.php');

$sql="SELECT u.login,b.Data,b.Descrizione FROM bug_reports AS b "
        . "JOIN users AS u ON b.ID=u.id WHERE 1 ORDER BY Data";

$ris=  mysql_safe_query($sql);
?>
<br/>
<table>
    <tr><td width="10%">Nome</td><td>Contenuto</td><td width="10%">Data</td></tr>
    <?php
while ($r = mysql_fetch_row($ris))
{
    ?>
<tr><td><?=$r[0]?></td><td><?=$r[2]?></td><td><?=$r[1]?></td></tr>
        <?php    
}
echo "</table>";
require ('../comuni/footer.php');

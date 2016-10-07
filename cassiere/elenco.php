<?php
require("../comuni/lib.php");
autentica(CASSIERE);
$titolo="Elenco utenti";
require("../comuni/header.php");
$sql="SELECT * FROM users";
$ris=mysql_safe_query($sql);


$intest=array("Login","Nome","Cognome","Mail","Cellulare","Saldo","Azioni");
$dim=array("10%","15%","15%","15%","10%","10%","25%");
$righe=array();
while($ut=mysql_fetch_row($ris))
{
    ?>
  
        <div id="modal<?=$ut[0]?>" class="modal">
            <div class="modal-content">
            <h4>Dettagli</h4>
            <p>
                Login: <?=$ut[1]?><br/>
		Nome:   <?=$ut[2]?><br/>
		Cognome:<?=$ut[3]?><br/>
		Mail:<?=$ut[4]?><br/>
		Cellulare:<?=$ut[5]?><br/>
                Codice Fiscale:<?=$ut[10]?><br/>
		Privilegi:<?=priv_to_human($ut[9])?><br/>
		Saldo:<?=id_to_saldo($ut[0])?><br/>
		Data ultimo rinnovo:<?=stampa_data($ut[7])?><br/>
		
                
            </p></div>
        <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Chiudi</a>
        
        </div>
        </div>
        


    <?php
    
    $righe[]=array($ut[1],$ut[2],$ut[3],$ut[4],$ut[5],  id_to_saldo($ut[0]),
        "<a class=\"modal-trigger waves-effect waves-light btn\" href=\"#modal$ut[0]\">Dettagli</a> &nbsp;"
            . "<a class=\"waves-effect waves-light btn\" href=\"./storico.php?id=$ut[0]\" target=\"_blank\">Storico</a>");
}
agg_tabella($intest, $righe, $dim, "utenti");
/*
//intestazione tabella
?>
<FORM action="" method=GET>
<table>
	<tr>
		<td>Login</td>
		<td>Nome</td>
		<td>Cognome</td>
		<td>Mail</td>
		<td>Cellulare</td>
                <td>Codice Fiscale</td>
		<td>Privilegi</td>
		<td>Saldo</td>
		<td>Data ultimo rinnovo</td>
		<td>Azioni</td>
		
	</tr>



<?php
while($ut=mysql_fetch_row($ris))
{
//riga della tabella:
?>
	<tr>
	<td><?=$ut[1]?></td>
	<td><?=$ut[2]?></td>
	<td><?=$ut[3]?></td>
	<td><?=$ut[4]?></td>
	<td><?=$ut[5]?></td>
        <td><?=$ut[10]?></td>
	<td><?=priv_to_human($ut[9])?></td>
	<td><?=id_to_saldo($ut[0])?></td>
	<td><?=stampa_data($ut[7])?></td>
	<td>
	<input value="Gestisci" type=button onClick="document.location='mod_utente.php?id=<?=$ut[0]?>'"/>&nbsp;
	<input value="Mod Pswd" type=button onClick="document.location='mod_password.php?id=<?=$ut[0]?>'"/>&nbsp;
	<input value="Elimina" type=button onClick="document.location='elimina.php?id=<?=$ut[0]?>'"/><br/>
	<input value="Rinnova" type=button onClick="document.location='rinnova.php?id=<?=$ut[0]?>'"/>&nbsp;
	<input value="Storico" type=button onClick="document.location='../cassiere/storico.php?id=<?=$ut[0]?>'"/>
	
	</td>
	</tr>
<?php
}*/
?>
</form>

    
    <script> 
        $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true // Displays dropdown below the button
      
         }
            );
    
      $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
  });
    </script>
    <?php
require("../comuni/footer.php");
?>


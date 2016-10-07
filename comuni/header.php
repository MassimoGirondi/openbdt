<?php
//require("lib.php");
dbconnect();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <link href="../comuni/bdt.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../comuni/jquery.js"></script>
        <script type="text/javascript" src="../comuni/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="../comuni/lib.js"></script>
        
        <link type="text/css" rel="stylesheet" href="../comuni/materialize/css/materialize.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <script type="text/javascript" src="../comuni/materialize/js/materialize.min.js"></script>
        <title>
		<?php         
                if (isset($titolo)) {echo $titolo . " - ";}
                echo $nomebdt;
		?>
	</title>

        
    </head>
    <body>
	
	<div class="intestazione">
            <img class="logo" src="../comuni/logo.png"> </img>
            <div class="titolo"><?=$nomebdt?></div>
		
	</div>

<div id='cssmenu'>
<ul>
   	
    <li><a href= "../comuni/loggato.php">Home</a></li>
        <li><a href= "../utente/agg_scambio.php">Aggiungi Scambio</a></li>
        <li><a href= "../utente/abilitas.php">Lista abilit&agrave;</a></li>
	<li><a href= "../utente/mod_dati.php">Gestisci i tuoi dati</a></li>
	<li><a href= "../utente/storico.php">Saldo</a></li>
	<?php if($_SESSION["priv"]>=CASSIERE)
                {?>
                <li><a class="active has-sub" href="#">Menu cassiere</a>
                    <ul class="subs">
                        <li><a href="../cassiere/conferma_scambi.php">Conferma scambi</a></li>
                        <li><a href="../cassiere/vedi_scambi.php">Vedi tutti gli scambi</a></li>
                        <li><a href="../cassiere/agg_scambio_terzo.php" >Aggiungi scambio terzo</a></li>
                        <li><a href="../cassiere/tutte_abilita.php">Visualizza tutte le abilit&agrave;</a></li>
   
                        <li><a href="../cassiere/storico.php">Saldo utente</a></li>
                        <li><a href="../cassiere/indirizzi.php" >Report indirizzi</a></li>
                        <li><a href="../cassiere/elenco.php" class='last' >Anagrafiche</a></li>
                        <li><a href="../cassiere/agg_cat.php">Aggiunta categoria</a></li>            
                        <li><a href="../cassiere/agg_subcat.php">Aggiunta sottocategoria</a></li>  
                        
                    </ul>
                </li>
                <?php
                }
                if($_SESSION["priv"]>=ADMIN)
                {?>
                <li><a class="has-sub" href="#">Menu amministratore</a>
                    <ul class="subs">
                        <li><a href="../admin/elenco.php">Gestione utenti</a></li>
                        <?php //<li><a href="../admin/massiva.php">Approva utenti</a></li> ?>
                        <li><a href="../admin/agg_utente.php" >Aggiungi utente</a></li>
                        <li><a href="../bkp_db/backup.php?msg&key=<?php echo $chiave_bkp?>" class='last'>BACKUP DATABASE</a></li>
                    </ul>
                </li>
                <?php } ?>

	<li class='last'><a href="../comuni/logout.php">Logout</a></li>


</ul>
</div>
<div class=container123>
        

<br/>
<?php require_once("./comuni/lib.php");?>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="./comuni/bdt.css" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
                <script type="text/javascript" src="./comuni/jquery.js"></script>
        <link type="text/css" rel="stylesheet" href="./comuni/materialize/css/materialize.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/><!--, user-scalable=no-->
        <script type="text/javascript" src="./comuni/materialize/js/materialize.min.js"></script>
        <title>
		Login - <?php echo $nomebdt;?>
	</title>

        
    </head>
    <body>
        
        <div class="intestazione">
            <img class="logo" src="./comuni/logo.png"> </img>
            <div class="titolo"><?=$nomebdt?></div>
		
	</div>
        <div class="login" style="margin:auto; max-width: 50%; min-width: 150px;">
        <?php
        if(isset($_REQUEST['e']))
        {
            $e=$_REQUEST['e'];
            if($e==-1)
                 echo "<div class=errore>Errore nell'accesso!!(Password o username sbagliati o non inseriti correttamente)</div>";
        
            else
                if($e==-2) 
                    echo "<div class=errore>Utente non abilitato all'accesso, attendi l'email di conferma</div>";
    
                
        }
        ?>
        
        
		<FORM action="index.php" method="POST">
                    <label for=login>user:</label> <INPUT type=text name=login /><br/>
			<label for=password>password:</label> <INPUT type=password name=password /><br/>
                        <input type="hidden" name="jscheck" id="jscheck" value="" />
                       <button class="btn waves-effect waves-light" type="submit" name="submit" value="ENTRA">Entra
                        <i class="mdi-content-send right"></i>
                       </button>
		</FORM>
                </div>  
          <div class="row s12">
        <div class="col s6 m6" style="margin: auto;">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Problemi?</span>
              <p>Non ricordi le credenziali o non sei registrato?</p>
            </div>
            <div class="card-action">
             <a href="./rec_password/index.php"> Recupero password</a>
             <a href="nuovo/index.php">Nuovo account</a>
            </div>
          </div>
        </div>
        <div class="col s6 m6" style="margin: auto;">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Avviso</span>
              <p>Questo sito &egrave; stato pensato per essere visualizzato attraverso Google Chrome.</p>
            </div>
            <div class="card-action">
             <a href="https://www.google.com/intl/it/chrome/">Scarica Google Chrome</a><br/>
            </div>
          </div>
        </div>      
              
              
      </div>
       &nbsp;Se neccessario puoi chiedere aiuto a <?php include "./helpmail.html"; ?>.

               <!-- <h6>Questo sito necessita che nel tuo browser sia attivato javascript!(se non sai cosa sia puoi pure ignorare questo messaggio)</h6>
             --> 
      <script>$('#jscheck').val("yes");</script>
                
                
                
                
    </body>
</html>

<?php
require_once("config.php");
//funzioni per il db
function dbconnect() {
	global $dbserver, $dbuser, $dbpass, $dbname;
	mysql_connect ($dbserver, $dbuser, $dbpass ) 
		or die ("Impossibile connettersi al server: ".$dbserver); 

	mysql_select_db ($dbname) 
		or die ("Impossibile selezionare il database: ".$dbname);
}

function mysql_safe_query ($query) {

	$result = mysql_query($query)
		or die("Errore. Query fallita: "
			."<li>errorno=".mysql_errno()
			."<li>error=".mysql_error()
			."<li>query=".$query
		);
	return $result;
}
function mysql_date_to_human ($dt) { 
	$yr =strval(substr ($dt,0,4)); 
	$mo =strval(substr ($dt,5,2)); 
	$da =strval(substr ($dt,8,2)); 

	return date ("d/m/Y", mktime (0,0,0,$mo,$da,$yr)); 
} 

function mysql_human_to_date ($dt) {
	$da = strval (substr ($dt,0,2));
	$mo = strval (substr ($dt,3,2));
	$yr = strval (substr ($dt,6,4));
	return date ("Y-m-d", mktime (0,0,0,$mo,$da,$yr));
}
//funzioni per gestione utenti e scambi 	

function agg_utente($nome,$cognome,$login,$mail,$cellulare,$password,$privilegi,$cf)
{
	$sql="INSERT INTO users (nome,cognome,login,mail,cellulare,password,priv,data_rinnovo,cf)
	      VALUES ('$nome','$cognome','$login','$mail','$cellulare',MD5('$password'),$privilegi,'".oggi()."','$cf')";
	mysql_safe_query($sql);
	$sql="SELECT id,nome,cognome FROM users
		  WHERE nome='$nome' AND cognome='$cognome' 
		  ORDER BY id DESC";
	$ris=mysql_safe_query($sql);
	$id=mysql_fetch_row($ris)[0];
	return $id;

}

function agg_scambio($fornitore,$cliente,$ore,$data,$descrizione)
{
	$sql="INSERT INTO scambi (fornitore,cliente,ore,data,descrizione)"
                . "VALUES ('$fornitore','$cliente','$ore','$data','$descrizione')";
	mysql_safe_query($sql);
	$sql="SELECT id FROM scambi
		  ORDER BY id DESC";
	$ris=mysql_safe_query($sql);
	tassa($fornitore);
	
	return mysql_fetch_row($ris)[0];
}
function cambia_password($id,$nuova)
{
	$sql="UPDATE users SET password = MD5('$nuova') WHERE id='$id'";
	mysql_safe_query($sql);
}


define('UTENTE', 0);
define('CASSIERE', 1);
define('ADMIN', 2);
define('DISABILITATO', -1);
function cambia_privilegi($id,$nuovi)
{
	$sql="UPDATE users SET priv=$nuovi WHERE id=$id";
	mysql_safe_query($sql);
}
function mod_utente($id,$mail,$cellulare,$privilegi)
{
	$sql="UPDATE users SET mail='$mail',cellulare='$cellulare' WHERE id='$id'";
	mysql_safe_query($sql);
	$sql="UPDATE users SET priv = $privilegi WHERE id=$id";
	mysql_safe_query($sql);
	return $id;
}
function login_fix($nome,$cognome)
{
	$nome=str_replace(" ", "_", $nome);
	$cognome=str_replace(" ", "_", $cognome);
	$iniziale=substr ($nome,0,1);
	$login=$iniziale.$cognome;
	
	
	$sql="SELECT login FROM users WHERE login LIKE '$login%' ORDER BY login DESC";
	//echo $sql;
	$ris=mysql_safe_query($sql);	
	if(mysql_num_rows($ris)>0)
	{
	$ris=mysql_fetch_row($ris);
	$ris=$ris[0];
	$num=str_replace($login, "", $ris);
	//echo $num."<br/>";
	$num=1+((int)($num));
	//echo $num."<br/>";
	$login=$login.$num;
	}//echo $login."<br/>";
	return strtolower($login);
}
function elimina($id)//utente
{	$sql="DELETE FROM users WHERE id = '$id'";
	mysql_safe_query($sql);
        $sql="DELETE FROM annunci WHERE user_id = '$id'";
        mysql_safe_query($sql);
        $sql = "UPDATE `scambi` SET `fornitore`=-1 WHERE fornitore=$id";
        mysql_safe_query($sql);
        $sql = "UPDATE `scambi` SET `cliente`=-1 WHERE cliente=$id";
        mysql_safe_query($sql);
}

function scambi_da_confermare()
{
	$sql="SELECT s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.nome,f.cognome,f.login,c.nome,c.cognome,c.login,s.ok FROM (users AS f JOIN scambi AS s ON f.id = s.fornitore JOIN users AS c ON c.id=s.cliente) WHERE !s.ok ORDER BY s.data DESC";
	return mysql_safe_query($sql);
}
function scambio_confermato($id)
{
	$sql="UPDATE scambi SET ok=1 WHERE id= '$id'";
	return mysql_safe_query($sql);
}
function ottieni_scambio($id)
{
	$sql="SELECT s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.nome,f.cognome,f.login,c.nome,c.cognome,c.login,s.ok FROM (users AS f JOIN scambi AS s ON f.id = s.fornitore JOIN users AS c ON c.id=s.cliente) WHERE s.id= '$id'";
	return mysql_safe_query($sql);
}
function elimina_scambio($id)
{
	$sql="DELETE FROM scambi WHERE id = '$id'";
	mysql_safe_query($sql);
}
function scambi()
{
	$sql="SELECT s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.nome,f.cognome,f.login,c.nome,c.cognome,c.login,s.ok FROM users AS f JOIN scambi AS s ON f.id = s.fornitore JOIN users AS c ON c.id=s.cliente WHERE 1";
	return mysql_safe_query($sql);
}
function login_to_id($login)
{
	$sql="SELECT id FROM users WHERE login='$login'";
	return mysql_fetch_row(mysql_safe_query($sql))[0];
}
function utenti()//ouput del tipo "nome cognome (login)
{
	$sql="SELECT CONCAT(nome,\" \",cognome,\" (\",login,\")\") FROM `users` WHERE id>-1";
	return mysql_safe_query($sql);
}
function nome_utente($id)
{
	$sql="SELECT CONCAT(nome,\" \",cognome,\" (\",login,\")\") FROM `users` WHERE id='$id'";
	return mysql_fetch_row( mysql_safe_query($sql))[0];
}
function priv_to_human($p)
{
	switch($p)
	{
		case UTENTE: return "utente"; 
		case CASSIERE: return "cassiere"; 
		case ADMIN: return "admin";
                case DISABILITATO: return "disabilitato";
	}
        return null;
}

function domani()
{
	$domani=mktime (0,0,0,date("m")  ,date("d")+1,date("Y"));
	return date('Y-m-d',$domani);//resituisce la data per il calendario html5
}


/*
define('OFFERTA',1);
define('RICHIESTA',2);
	
function agg_annuncio($user_id,$descrizione,$tipo)
{
	if($tipo== OFFERTA || $tipo==RICHIESTA  )
			{ $sql="INSERT INTO annunci (user_id,descrizione,tipo) VALUES ('$user_id','$descrizione','$tipo')";
			mysql_safe_query($sql);
			//$sql="SELECT id FROM annunci ORDER BY id DESC";
			//$ris=mysql_safe_query($sql);
			//return mysql_fetch_row($ris)[0];
			}
			//else return -1;
}
function annunci()
{
	$sql = "SELECT a.id,u.id,a.descrizione,a.tipo,CONCAT(u.nome,\" \",u.cognome,\" (\",u.login,\")\"),u.cellulare,u.mail FROM annunci AS a JOIN users as u ON a.user_id=u.id WHERE 1 ORDER BY u.id";
	return mysql_safe_query($sql);
}
function cerca_annunci_par($cerco,$richiesta,$offerta)
{
    $sql = "SELECT a.id,u.id,a.descrizione,a.tipo,"
                . "CONCAT(u.nome,\" \",u.cognome,\" (\",u.login,\")\"),"
                . "u.cellulare,u.mail"
                . " FROM annunci AS a JOIN users as u ON a.user_id=u.id "
                . "WHERE (a.descrizione LIKE '%$cerco%') AND (";
    if ($richiesta) {
         $sql.= " a.tipo = ' ". RICHIESTA."'" ;
         if ($offerta) {
            $sql.= " OR a.tipo = '" . OFFERTA."'";
        }
    }
    else 
    {
        if ($offerta) {
            $sql.= " a.tipo =  '" . OFFERTA."'";
        } else 
        {
            $sql.= "TRUE";
        } //se non ho selezionato nulla
    }
    $sql.=") ORDER by a.id";
    return mysql_safe_query($sql);
}
*/
function login($user,$password)
{
	$id=-1;
	$sql="SELECT id FROM users WHERE login='$user' AND password=MD5('$password')";
	$ris=mysql_safe_query($sql);
	$quantiutenti=mysql_num_rows($ris);
        
	if ($quantiutenti == 1)
		{
			if ($row=mysql_fetch_array($ris))
				{
					$id=$row["id"];
				}
		}
        if($id!=-1)//quindi ho trovato qualcuno
        {
            if(id_to_priv ($id)==-1)//controllo se è abilitato
                $id=-2;
        }
            
	return $id;
}


function autentica($priv)
{
	session_start();
	/* se non è stato effettuato il login, si viene re-indirizzati alla pagina iniziale */
	if (!isset($_SESSION["id"])||$priv>$_SESSION["priv"])
		{
			header('Location: ../index.php');
			
		}
}

function login_form()
{
	require($GLOBALS['home']."/login.php");

}

function login_error($id)
{
    if($id==-1)
    {
        echo "Errore nell'accesso!!(Password o username sbagliati o non inseriti correttamente)";
        
    }
    else
    {
        if($id==-2) 
            echo "Utente non abilitato all'accesso, attendi l'email di conferma";
    }
}


function id_to_priv($id)
{	$priv=-1;
	$sql="SELECT priv FROM users WHERE id='$id'";
	$ris=mysql_safe_query($sql);
	if ($row=mysql_fetch_array($ris))
		$priv=$row["priv"];
	return $priv;
}
function id_to_saldo($id)
{
	$ore=0;
	$sql="SELECT SUM(ore) FROM scambi WHERE cliente='$id'";
	$ris=mysql_safe_query($sql);
	$cliente=mysql_fetch_row($ris)[0];//ore in cui l'utente ha ricevuto 
	$ore-=$cliente;
	$sql="SELECT SUM(ore) FROM scambi WHERE fornitore='$id'";
	$ris=mysql_safe_query($sql);
	$fornitore=mysql_fetch_row($ris)[0];//ore in cui l'utente ha dato 
	$ore+=$fornitore;
	return $ore;
}
function riepilogo($id)
{
	return "Ciao ".nome_utente($id).". Il tuo saldo è di ".id_to_saldo($id)." ore.<br/>";
}/*
function annunci_by_id($id)//id utente
{
	$sql = "SELECT a.id,u.id,a.descrizione,a.tipo,CONCAT(u.nome,\" \",u.cognome,\" (\",u.login,\")\") FROM annunci AS a JOIN users as u ON a.user_id=u.id WHERE u.id=$id ORDER BY a.id";
	return mysql_safe_query($sql);
}
function elimina_annuncio($id)
{
	$sql="DELETE FROM annunci WHERE id = '$id'";
	return mysql_safe_query($sql);
}
function annuncio_by_id($id)//id annuncio
{
	$sql="SELECT * FROM annunci WHERE id = '$id'";
	return mysql_fetch_row(mysql_safe_query($sql));
}
function mod_ann($id_ann,$descrizione,$tipo)
{
	$sql="UPDATE annunci SET descrizione='$descrizione', tipo='$tipo' WHERE id='$id_ann'";
	mysql_safe_query($sql);
}*/
function oggi()
{
	
	$oggi=mktime (0,0,0,date("m")  ,date("d"),date("Y"));
	return date('Y-m-d',$oggi);
}
function tassa($id)//id dell'utente a cui applicare le tasse se il saldo è maggiore al limite e diminuizione ore di immunità
{
    if($id!=BANCA && $id!=-1){
	$sql="SELECT tassa FROM users WHERE id= '$id'";
	$ris=mysql_fetch_row(mysql_safe_query($sql));
	$saldo=id_to_saldo($id);
	if($ris[0]==0)//se non è ancora stato tassato
	{
		if($saldo>LIM_TASSA)
		{
			agg_scambio(BANCA,$id,TASSA,oggi(),"Pagamento tasse");
			$sql="UPDATE users SET tassa=".(OGNI_QUANTO-ultime_ore_by_id($id))." WHERE id= '$id'";
			mysql_safe_query($sql);
		}
	}
	else
		if($ris[0]>0)//se è in fase di immunità(ore in cui non viene tassato)
			{
			$sql="UPDATE users SET tassa=".($ris[0]-ultime_ore_by_id($id))." WHERE id= '$id'";
			mysql_safe_query($sql);
			}	
    }
}
function ultime_ore_by_id($id)
{
	$sql="SELECT ore FROM `scambi` WHERE fornitore=$id ORDER BY id DESC";
	$ris=mysql_safe_query($sql);
	return $ris[0];
}


function cerca_annunci($cerco)
{
	$sql = "SELECT a.id,u.id,a.descrizione,a.tipo,CONCAT(u.nome,\" \",u.cognome,\" (\",u.login,\")\"),u.cellulare,u.mail
		FROM annunci AS a JOIN users as u ON a.user_id=u.id 
		WHERE  a.descrizione LIKE '%$cerco%'  ORDER BY u.id";
	return mysql_safe_query($sql);
}

function rinnova_utente($id)
{
	$sql="UPDATE users SET data_rinnovo='".oggi()."' WHERE id= '$id'";
	mysql_safe_query($sql);
}
function stampa_data($data)
{
	$ultimo=strtotime($data);
	$annofa=strtotime ( '-1 year' , strtotime ( oggi() ) ) ;
	if($ultimo<$annofa)
	{
	   return "<span class=rosso>".mysql_date_to_human ($data)."</span>";
	}
	else
		return mysql_date_to_human ($data);

}
function stampa_data_bis($data)
{
	$ultimo=strtotime($data);
	$annofa=strtotime ( '-1 year' , strtotime ( oggi() ) ) ;
	if($ultimo<$annofa)
	{
	   return "<b>Il tuo account &agrave; scaduto il giorno ".mysql_date_to_human ($data)."</b>";
	}
	else
            return "Il tuo account scadr&agrave; il giorno ".mysql_date_to_human ($data);
}
function mod_dati($id,$mail,$cellulare)
{
	
	$sql="UPDATE users SET mail='$mail',cellulare='$cellulare' WHERE id='$id'";
	mysql_safe_query($sql);
}
function ultimi_annunci()
{
	$sql = "SELECT a.id,u.id,a.descrizione,a.tipo,CONCAT(u.nome,\" \",u.cognome,\" (\",u.login,\")\"),u.cellulare,u.mail
		FROM annunci AS a JOIN users as u ON a.user_id=u.id 
		WHERE 1 ORDER BY a.id DESC LIMIT 5";
	return mysql_safe_query($sql);
}
function ore_tot()
{
	$sql="SELECT SUM(ABS(ore)) FROM scambi WHERE 1";
	return mysql_fetch_row(mysql_safe_query($sql))[0];
}

function scambi_by_id($id)
{
	$str="";
	$sql="SELECT s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.login,c.login
		FROM users AS f
		JOIN scambi AS s ON f.id = s.fornitore
		JOIN users AS c ON c.id=s.cliente
		WHERE s.cliente=$id OR s.fornitore=$id ORDER BY s.id DESC";
	$ris=mysql_safe_query($sql);
	while($s=mysql_fetch_row($ris))
	{
		if($s[1]==$id)//si tratta di uno scambio in guadagno
		{
		$str.="<tr>\n<td>".$s[7]."</td>\n";
		
		$str.="<td>".$s[4]."</td>\n";
		$str.="<td>".$s[5]."</td>\n";
		$str.="<td>".$s[3]."</td>\n</tr>\n";
		}
		else
		{
		$str.="<tr>\n<td>".$s[6]."</td>\n";
		$str.="<td>".$s[4]."</td>\n";
		$str.="<td>".$s[5]."</td>\n";
		$str.="<td>".($s[3]*(-1))."</td>\n</tr>\n";
		}
		
	}
	return $str;

}
function ore_tot_by_id($id)
{
	$sql="SELECT SUM(ABS(ore)) FROM scambi WHERE cliente=$id OR fornitore=$id";
        $ris=mysql_fetch_row(mysql_safe_query($sql))[0];
	return $ris==""?0:$ris;
}

function indirizzi()
{
    $sql="SELECT mail FROM users WHERE priv > ".DISABILITATO." AND mail IS NOT NULL AND mail != \"\"" ;
    $str="";
    $ris=mysql_safe_query($sql);
    while($r=mysql_fetch_row($ris))
    {
        $str.=($r[0]."<br/>");
    }
    return $str;
}
function id_to_mail($id)
{
    $sql="SELECT mail FROM users WHERE id='$id'";
    return mysql_fetch_row(mysql_safe_query($sql))[0];
}
function id_to_user($id)
{
       $sql="SELECT login FROM users WHERE id='$id'";
    return mysql_fetch_row(mysql_safe_query($sql))[0]; 
}

function invia_mail($a,$oggetto,$messaggio)
{
 global $noreplymail;
 //echo $mail;
    //INvIO MAIL
   // echo '<script type="text/javascript">alert("a:'.$a.',\nogg:'.$oggetto.'\nmsg: '.$messaggio.'");</script>';
    

if (preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/", $a)) 
{
	
        mail($a,html_entity_decode($oggetto), html_entity_decode($messaggio),
                "From: ".$noreplymail."\r\n" .
                "Content-Type: text/html; charset=\"iso-8859-1\"\n". 
                "X-Mailer: PHP/" . phpversion());     
        
        
        aggiungi_feed("mail", "$a;\n $oggetto ;\n $messaggio");
}

}

function aggiungi_feed($titolo,$msg)
{
    $titolo=  mysql_real_escape_string($titolo);
    $msg=  mysql_real_escape_string($msg);
    $sql="INSERT INTO feed (titolo,contenuto) VALUES('$titolo','$msg')";
    mysql_safe_query($sql);
}
function stampa_feed()
{
    $sql="SELECT * FROM feed ORDER BY Data DESC";
    return mysql_safe_query($sql);
    
}

function printCategorie()
{
    $sql="SELECT c.id, s.id, c.nome, s.nome FROM subCategorie AS s JOIN Categorie AS c ON c.id = s.padre ORDER BY c.nome,s.nome";
    $ris=  mysql_safe_query($sql);
    $r=  mysql_fetch_row($ris);
    $s=$r;
    echo "<optgroup label=\"$r[2]\">\n";
    
    while($r)
    {
        echo "<option value=$r[0].$r[1]>$r[3]</option>\n";
        $s=$r;
        $r=  mysql_fetch_row($ris);
        if ($r && $r[0] != $s[0]) {
            echo "</optgroup>\n"
            . "<optgroup label=$r[2]>\n";
        }
    }
    
}
function printsoloCategorie()
{
    $sql="SELECT ID,Nome FROM Categorie ORDER BY Nome";
    $ris=  mysql_safe_query($sql);
   
    while($r=  mysql_fetch_row($ris))
    {
        echo "<option value=$r[0]>$r[1]</option>\n";
        
    }
    
}

function agg_abilita($uid,$cat,$sub,$note)
{
    $sql="INSERT INTO abilita (user_id,categoria,subcategoria,note) VALUES ('$uid','$cat','$sub','$note')";
    mysql_safe_query($sql);
}
function abilitas()
{
    $sql = "SELECT u.login,u.nome,u.cognome,c.nome,s.nome,a.note,u.mail,u.cellulare,a.id\n"
    . "FROM abilita AS a \n"
    . "JOIN subCategorie AS s ON a.subCategoria=s.id AND a.categoria=s.padre\n"
    . "JOIN Categorie AS c ON a.categoria=c.id\n"
    . "JOIN users AS u ON u.id=a.user_id\n"
    . "ORDER BY a.categoria,a.subcategoria";
    return mysql_safe_query($sql);
}
function abilitas_by_uid($uid)
{
    $sql = "SELECT c.nome,s.nome,a.note,a.id\n"
    . "FROM abilita AS a \n"
    . "JOIN subCategorie AS s ON a.subCategoria=s.id AND a.categoria=s.padre\n"
    . "JOIN Categorie AS c ON a.categoria=c.id\n"
    . "WHERE a.user_id=$uid \n"
    . "ORDER BY a.categoria,a.subcategoria";
    return mysql_safe_query($sql);
}

function elimina_abilita($id,$uid)
{
    $sql="DELETE FROM abilita WHERE id='$id' AND User_id='$uid'";
    mysql_safe_query($sql);
}

function printCategorie_selected($c,$t)
{
    $sql="SELECT c.id, s.id, c.nome, s.nome FROM subCategorie AS s JOIN Categorie AS c ON c.id = s.padre ORDER BY c.nome,s.nome";
    $ris=  mysql_safe_query($sql);
    $r=  mysql_fetch_row($ris);
    $s=$r;
    echo "<optgroup label=\"$r[2]\">\n";
    
    while($r)
    {
        echo "<option value=$r[0].$r[1]";
        if ($c == $r[0] && $t == $r[1]) 
        {
            echo " selected";
        }
        echo ">$r[3]</option>\n";
        $s=$r;
        $r=  mysql_fetch_row($ris);
        if ($r && $r[0] != $s[0]) {
            echo "</optgroup>\n"
            . "<optgroup label=$r[2]>\n";
        }
    }
    
}

function abilita_by_id($id)
{
    $sql = "SELECT * \n"
    . "FROM abilita \n"
    . "WHERE id=$id";
    return mysql_fetch_row(mysql_safe_query($sql));
}
function mod_abilita($uid,$id,$cat,$sub,$note)
{
    $sql="UPDATE `abilita` SET `Categoria`=$cat,`SubCategoria`=$sub,`Note`='$note'"
            . " WHERE User_id=$uid AND ID=$id";

    mysql_safe_query($sql);
}
function abilitas_cassiere()
{
    $sql = "SELECT u.login,c.nome,s.nome,a.note,a.id\n"
    . "FROM abilita AS a \n"
    . "JOIN subCategorie AS s ON a.subCategoria=s.id AND a.categoria=s.padre\n"
    . "JOIN Categorie AS c ON a.categoria=c.id\n"
    . "JOIN users AS u ON a.User_id=u.id\n"
    . "ORDER BY a.categoria,a.subcategoria";
    return mysql_safe_query($sql);
}

function print_utenti()
{
    $sql="SELECT CONCAT(nome,\" \",cognome,\" (\",login,\")\"),id FROM `users` WHERE id>-1";
    $ris= mysql_safe_query($sql);
    while($r=mysql_fetch_row($ris))
    {
        echo "<option value=$r[1]>$r[0]</option>\n";
    }
}
function print_utenti_selected($id)
{
    $sql="SELECT CONCAT(nome,\" \",cognome,\" (\",login,\")\"),id FROM `users` WHERE id>-1";
    $ris= mysql_safe_query($sql);
    while($r=mysql_fetch_row($ris))
    {
        echo "<option value=$r[1]";
        if($r[1]==$id)
        {
            echo " selected ";
        }
        echo ">$r[0]</option>\n";
    }
}
function elimina_abilita_cassiere($id)
{
    $sql="DELETE FROM abilita WHERE id='$id'";
    mysql_safe_query($sql);
}
function mod_abilita_cassiere($id,$cat,$sub,$note)
{
    $sql="UPDATE `abilita` SET `Categoria`=$cat,`SubCategoria`=$sub,`Note`='$note'"
        . " WHERE ID=$id";
    mysql_safe_query($sql);
}
function explain_cat($cat,$sub)
{
    $sql="SELECT c.nome, s.nome "
       . "FROM subCategorie AS s "
       . "JOIN Categorie AS c ON c.id = s.padre "
       . "WHERE c.id=$cat AND s.id=$sub";
    $ris=  mysql_safe_query($sql);
    return mysql_fetch_row($ris);
}
function utenti_inattesa()
{
    $sql="SELECT id,login,nome,cognome,mail,cellulare,cf FROM users WHERE priv=".DISABILITATO." AND id !=".BANCA." AND id != -1";
    return mysql_safe_query($sql);
}

function admins()
{
    $sql="SELECT mail FROM users WHERE priv=".ADMIN;
    return mysql_safe_query($sql);
}
function mail_a_admins($ogg,$msg)
{
    $admins=  admins();
    while ($row = mysql_fetch_row($admins))
    {
        //$a=$row[0];
        invia_mail($row[0], $ogg, $msg);
    }
}
function cassieri()
{
    $sql="SELECT mail FROM users WHERE priv=".CASSIERE;
    return mysql_safe_query($sql);
}
function mail_a_cassieri($ogg,$msg)
{
    $cass=  cassieri();
    while ($row = mysql_fetch_row($cass))
    {
        $a=$row[0];
        invia_mail($a, $ogg, $msg);
    }
}
function agg_bug($id,$desc)
{
    
    $sql="INSERT INTO bug_reports (ID,Descrizione) VALUES('$id','$desc')";
    mysql_safe_query($sql);
}

function credenziali_mail($id)
{
 	$sql="SELECT login,password FROM users WHERE id='$id'";
    	$r=mysql_fetch_row(mysql_safe_query($sql));
	return "User:".$r[0]."<br/>\nLa password  &egrave; quella che hai inserito in fase di registrazione";
}

function check_cf($cf)
{
    $reg="/^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$/";
    if(preg_match($reg, $cf))
    {
    $sql="SELECT id FROM users WHERE cf='$cf'";
    $r=mysql_fetch_row(mysql_safe_query($sql));
    return $r== null;
    }
    else return false;
}
function check_mail($mail)
{
    if($mail=="") return true;// se non e' stata inserita va bene
   // $reg="/^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$/";
    //if(preg_match($reg, $cf))
    //{
    $sql="SELECT id FROM users WHERE mail='$mail'";
    $r=mysql_fetch_row(mysql_safe_query($sql));
    return $r== null;
    //}
    //else return false;
}

function check_mail_2($mail)
{
    if($mail=="") return true;// se non e' stata inserita va bene
   // $reg="/^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$/";
    //if(preg_match($reg, $cf))
    //{
    $sql="SELECT id FROM users WHERE mail='$mail'";
    $r=mysql_fetch_row(mysql_safe_query($sql));
    return $r;
    //}
    //else return false;
}


function agg_tabella($intestazioni,$righe,$dimensioni,$id)
    {
        //echo implode($intestazioni);
        $tabella="\n<table class=\"tab tablesorter\" id=$id>\n<thead>\n<tr>";
        $l=  count($intestazioni);
        for($i=0;$i<$l;$i++)
        {
            $tabella.="<th  style=\"width:$dimensioni[$i]%\">$intestazioni[$i]<span></span></th>\n";
        }
        $tabella.="</tr>\n</thead>\n<tbody id=\"".$id."_body\">\n";
        foreach ($righe as $riga) 
        {
            
            //echo implode($riga);
            $tabella.="<tr>\n";
            foreach ($riga as $cella) 
            {
            $tabella.="<td>$cella</td>\n";
            }
            $tabella.="</tr>\n";
        }
        //echo "Novit&agrave;! Premendo sull'intestazione di una colonna la si ordina.Puoi anche selezionare pi&ugrave; colonne tenendo premuto il tasto shift.";
        $tabella.="</tbody>\n</table>\n";
        echo $tabella;
        ?>
            <script>
                    $(document).ready(function() { 

                      $("#<?=$id?>").tablesorter();
                    });
        </script>
            <?php
    }
    function cerca_mail($mail)
    {
        $sql="SELECT id FROM users WHERE mail='$mail'";
        $r=mysql_fetch_row(mysql_safe_query($sql));
        return $r!= null;
    }
    /*function codifica_utente($user)
    {
        $n= rand(1, 4);
        $cod="utente:".$user;
        switch ($n) {
            case 1: $cod.="gh21";   break;
            case 2: $cod.="12hd";   break;
            case 3: $cod.="5grr";   break;
            case 4: $cod.="12ws";   break;
            default: $cod="sa23";   break;
        }
        $cod= base64_encode($cod); 
        return $cod."a";
    }
    function decodifica_utente($cript)
    {
        $s=substr($cript, 0, strlen($cript)-1);
        $decod= base64_decode($s); 
//        echo "decodificato:".$decod;
        $decod=substr($decod, 0,  strlen($decod)-4); 
//        echo "<br>substr:".$decod;
        $decod=  split(":", $decod)[1];
//        echo "<br>split:".$decod;
        return $decod;
    }
    
    function base64_correct($data)
    {
        return base64_encode(base64_decode($data, true)) === $data;
    }
     */
    function mail_to_login($mail)
    {
        $sql="SELECT login FROM users WHERE mail='$mail'";
        $r=mysql_fetch_row(mysql_safe_query($sql))[0];
        if($r!=null)
            return $r;
        else
            return false;
    }
    
    function password_random($lunghezza=12){
	$caratteri_disponibili ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$codice = "";
	for($i = 0; $i<$lunghezza; $i++){
		$codice = $codice.substr($caratteri_disponibili,rand(0,strlen($caratteri_disponibili)-1),1);
	}
	return $codice;
}
    function mail_to_id($mail)
    {
        $sql="SELECT id FROM users WHERE mail='$mail'";
        $r=mysql_fetch_row(mysql_safe_query($sql))[0];
        if($r!=null)
            return $r;
        else
            return false;
    }
    function cerca_user($user)
    {
        
        
        $sql="SELECT id,nome,cognome,login,cellulare FROM users WHERE login='$user'";
        $r=mysql_fetch_row(mysql_safe_query($sql));
        if($r!=null)
            return $r;
        else
            return false;
        
        
    }
function conferma_utente($id)
{
    $sql="UPDATE users SET priv=0 WHERE id='$id'";
    mysql_safe_query($sql);
    
    $a=  id_to_mail($id);
    $oggetto="Iscrizione ".$nomebdt;
    $messaggio="Ciao, il tuo account &egrave; stato approvato.";
    $messaggio.="Queste sono le credenziali per l'accesso:\n"
            //. "\nUtente: $login\nPassword: $password"
            .credenziali_mail($id)."\n"
            . "Il sito &egrave; raggiungibile all'indirizzo "
            . "  $home";
    //($a,$oggetto,$messaggio);
    mailer_new($a, $oggetto, $messaggio);
    
}
function dettagli_abilita($id)
{
    $sql = "SELECT u.login,u.nome,u.cognome,c.nome,s.nome,a.note,u.mail,u.cellulare,a.id\n"
    . "FROM abilita AS a \n"
    . "JOIN subCategorie AS s ON a.subCategoria=s.id AND a.categoria=s.padre\n"
    . "JOIN Categorie AS c ON a.categoria=c.id\n"
    . "JOIN users AS u ON u.id=a.user_id\n"
    . "WHERE a.id= '$id'";
    return mysql_fetch_row(mysql_safe_query($sql));
}    
function dettagli_abilita_modal($id)
{
    $ret="<div id=\"modal$id\" class=\"modal\">\n
            <div class=\"modal-content\">\n
            <h4>Dettagli</h4>
            <p>\n";
    
    $dett=  dettagli_abilita($id);
    $ret.="Nome: $dett[1]<br/>\n";
    $ret.= "Cognome: $dett[2]<br/>\n";
    $ret.= "Username: $dett[0]<br/>\n";
    $ret.= "Categoria: $dett[3]\n<br/>";
    $ret.= "Sottocategoria: $dett[4]<br/>\n";
    $ret.= "Note: $dett[5]<br/>\n";
    $ret.= "Mail: $dett[6]<br/>\n";
    $ret.= "Cellulare: $dett[7]<br/>\n";
    $ret.="</p></div>\n
        <div class=\"modal-footer\">\n
        <a href=\"#!\" class=\" modal-action modal-close waves-effect waves-green btn-flat\">Chiudi</a>\n
        </div>\n
        </div>\n";
        
    return $ret;
}

function scambi_by_id_array($id)
{
    $ret[]=array();
	$sql="SELECT s.id,s.fornitore,s.cliente,s.ore,s.data,s.descrizione,f.login,c.login
		FROM users AS f
		JOIN scambi AS s ON f.id = s.fornitore
		JOIN users AS c ON c.id=s.cliente
		WHERE s.cliente=$id OR s.fornitore=$id ORDER BY s.id DESC";
	$ris=mysql_safe_query($sql);
	while($s=mysql_fetch_row($ris))
	{
		if($s[1]==$id)//si tratta di uno scambio in guadagno
		{
                    $ret[]=array($s[7],$s[4],$s[5],$s[3]);
		}
		else
		{
                    $ret[]=array($s[6],$s[4],$s[5],($s[3]*(-1)));
		}
		
	}
	return $ret;

}


/*

 *QUERY:
 (SELECT DISTINCT catnome,Note
FROM (
    SELECT c.id AS cat, s.id AS sub, c.nome AS catnome, s.nome AS subnome
	FROM subCategorie AS s 
    JOIN Categorie AS c ON c.id = s.padre
    WHERE c.id = 0) AS categorie
	JOIN abilita
	ON abilita.Categoria=categorie.cat AND categorie.sub=abilita.SubCategoria
	ORDER BY catnome,Note
)

UNION
(
SELECT DISTINCT catnome,subnome
FROM (
    SELECT c.id AS cat, s.id AS sub, c.nome AS catnome, s.nome AS subnome
	FROM subCategorie AS s 
    JOIN Categorie AS c ON c.id = s.padre
    WHERE c.id != 0
    ORDER BY c.nome,s.nome) AS categorie
JOIN abilita
ON abilita.Categoria=categorie.cat AND categorie.sub=abilita.SubCategoria
)
 * 
 *  */
function abilita_pubbliche()
{
$sql = "(SELECT DISTINCT catnome,Note
FROM (
SELECT c.id AS cat, s.id AS sub, c.nome AS catnome, s.nome AS subnome
FROM subCategorie AS s 
JOIN Categorie AS c ON c.id = s.padre
WHERE c.id = 0) AS categorie
JOIN abilita
ON abilita.Categoria=categorie.cat AND categorie.sub=abilita.SubCategoria
ORDER BY catnome,Note
)

UNION
(
SELECT DISTINCT catnome,subnome
FROM (
SELECT c.id AS cat, s.id AS sub, c.nome AS catnome, s.nome AS subnome
FROM subCategorie AS s 
JOIN Categorie AS c ON c.id = s.padre
WHERE c.id != 0
ORDER BY c.nome,s.nome) AS categorie
JOIN abilita
ON abilita.Categoria=categorie.cat AND categorie.sub=abilita.SubCategoria
)";
    $ris=  mysql_safe_query($sql);
    $ris2=array();
    while($r=mysql_fetch_array($ris))
    {
        $ris2[]=array($r[0],$r[1]);
    }
    return $ris2;
}
function agg_subcategoria($padre,$desc)
{
    $sql="INSERT INTO subCategorie(Padre,Nome) VALUES ('$padre','$desc')";
    mysql_safe_query($sql);
}
function agg_categoria($desc)
{
    $sql="INSERT INTO Categorie(Nome) VALUES ('$desc')";
    mysql_safe_query($sql);
}

function mailer_new($destinatario,$oggetto,$testo)
{
    global $noreplymail;
    global $username;
    global $pass;
    global $host;
    global $port;
    global $nomebdt;
    global $infomail;
    require_once "../comuni/PHPMailer/class.phpmailer.php";
$messaggio = new PHPmailer();
$messaggio->IsSMTP();
$messaggio->Host=$host;
$messaggio->SMTPAuth= true;                  // enable SMTP authentication
$messaggio->Port= $port; 
$messaggio->Username   = $username; // SMTP account username
$messaggio->Password   = $pass; 
$messaggio->From=$noreplymail;
$messaggio->FromName= "$nomebdt - Gestionale";
$messaggio->From=$noreplymail;
$messaggio->AddAddress($destinatario);
$messaggio->AddReplyTo($infomail); 
$messaggio->Subject=$oggetto;
$messaggio->IsHTML(true);
$messaggio->Body=stripslashes($testo);
$res="ok";
if(!$messaggio->Send()){ 
  $res=$messaggio->ErrorInfo; 
}
aggiungi_feed("phpmailer", "$res-$destinatario;\n $oggetto ;\n $testo");
$messaggio->SmtpClose();
unset($messaggio);
}
function mailer_new_multipli_esposti($destinatari,$oggetto,$testo)
{
    global $noreplymail;
    global $username;
    global $pass;
    global $host;
    global $port;
    global $nomebdt;
    global $infomail;
    require_once "../comuni/PHPMailer/class.phpmailer.php";
$messaggio = new PHPmailer();
$messaggio->IsSMTP();
$messaggio->Host=$host;
$messaggio->SMTPAuth= true;                  // enable SMTP authentication
$messaggio->Port= $port; 
$messaggio->Username   = $username; // SMTP account username
$messaggio->Password   = $pass; 
$messaggio->From=$noreplymail;
$messaggio->FromName= "$nomebdt - Gestionale";
$messaggio->From=$noreplymail;

foreach ($destinatari as $destinatario) {
    $messaggio->AddAddress($destinatario);
}
$messaggio->AddReplyTo($infomail); 
$messaggio->Subject=$oggetto;
$messaggio->IsHTML(true);
$messaggio->Body=stripslashes($testo);
$res="ok";
if(!$messaggio->Send()){ 
  $res=$messaggio->ErrorInfo; 
}
aggiungi_feed("phpmailer", "$res-".implode($destinatari).";\n $oggetto ;\n $testo");
$messaggio->SmtpClose();
unset($messaggio);
}

function mailer_new_multipli_ccn($destinatari,$oggetto,$testo)
{
    global $noreplymail;
    global $username;
    global $pass;
    global $host;
    global $port;
    global $nomebdt;
    global $infomail;
    require_once "../comuni/PHPMailer/class.phpmailer.php";
$messaggio = new PHPmailer();
$messaggio->IsSMTP();
$messaggio->Host=$host;
$messaggio->SMTPAuth= true;                  // enable SMTP authentication
$messaggio->Port= $port; 
$messaggio->Username   = $username; // SMTP account username
$messaggio->Password   = $pass; 
$messaggio->From=$noreplymail;
$messaggio->FromName= "$nomebdt - Gestionale";
$messaggio->From=$noreplymail;

foreach ($destinatari as $destinatario) {
    $messaggio->AddBCC($destinatario);
}
$messaggio->AddReplyTo($infomail); 
$messaggio->Subject=$oggetto;
$messaggio->IsHTML(true);
$messaggio->Body=stripslashes($testo);
$res="ok";
if(!$messaggio->Send()){ 
  $res=$messaggio->ErrorInfo; 
}
aggiungi_feed("phpmailer", "$res-".implode($destinatari).";\n $oggetto ;\n $testo");
$messaggio->SmtpClose();
unset($messaggio);
}

function mailer_new_admins($oggetto,$contenuto)
{
$destinatari=array();//array per i destinatari
$admins=admins();//indirizzi amministratori
while ($row = mysql_fetch_array($admins))
{
    $destinatari[]=$row[0];
}
mailer_new_multipli_esposti($destinatari, $oggetto,$contenuto);
}
function mailer_new_cassieri($oggetto,$contenuto)
{
$destinatari=array();//array per i destinatari
$cassieri=  cassieri();//indirizzi cassieri
while ($row = mysql_fetch_array($cassieri))
{
    $destinatari[]=$row[0];
}
mailer_new_multipli_esposti($destinatari, $oggetto,$contenuto);
}



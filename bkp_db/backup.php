<?php
require("../comuni/lib.php");
require("./mysql_backup.php");

if(isset($_REQUEST["key"]) && mysql_escape_string($_REQUEST["key"])==$chiave_bkp)
{
dbconnect();

$backup_obj = new MySQL_Backup();
$backup_obj->connected = true;		// già connesso al db
$backup_obj->drop_tables = true;	// aggiungi drop table
$backup_obj->struct_only = false;	// struttura e dati
$backup_obj->comments = false;		// no commenti
$backup_obj->backup_dir="./dump/";

$filename = "backup_".str_replace(' ','',$nomebdt)."_".date('d-m-Y').".sql.gz";
$backup_obj->Execute(MSB_SAVE, $filename, true);

if(isset($_REQUEST["msg"]))
{
    echo "Backup eseguito, salvato all'interno dello spazio web. Sarai reindirizzato automaticamente.";
    header('refresh: 5; url=../index.php');
    
}
}
else
	echo "Error! Pagina sbagliata";
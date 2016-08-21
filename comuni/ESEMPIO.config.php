<?php

//Togliere il comment per abilitare la segnalazione degli errori
//error_reporting(E_ALL);

global $home;
$nomebdt = 'NOME BDT';
$home = "http://www.bdt.org/openbdt";
$dbserver = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'DB0';
define('LIM_TASSA',10);//dopo quanto applicare la tassazione
define('TASSA',1);//di quanto tassare
define('OGNI_QUANTO',5);
define('BANCA',1);//id dell'utente della banca nel db
$sito="della Bdt di NOME PAESE";   //USATO NELLA FRASE: relative esclusivamente all'attivita $sito
//
//parametri per il reCAPTCHA
$chiavesito="CHIAVE1";
$chiavesegreta="CHIAVE2";
$lingua="it";
//configurazione mailer smtp per invio mail(attenzione con Gmail)
$noreplymail="no-reply@bdt.org";
$username="no-reply@bdt.org";
$pass="1Password";
$host="smtp.bdt.org";
$port="587";
$infomail="info@bdt.org";//indirizzo di risposta delle mail inviate in automatico
$chiave_bkp="chiavesegreta";
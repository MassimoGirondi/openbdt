# Openbdt
Copyright (C) 2014-2016 Massimo Girondi massimo@girondi.net


OpenBdT-Software gestionale per banche del tempo

Questo  programma e' software libero; e' lecito redistribuirlo e/o
modificarlo secondo i termini della Licenza Pubblica Generica GNU
versione 3, come pubblicata dalla Free Software Foundation.

Questo programma e' distribuito nella speranza che sia utile, ma
SENZA  ALCUNA GARANZIA; senza  neppure la  garanzia implicita di
NEGOZIABILITA' o di APPLICABILITA' PER UN PARTICOLARE SCOPO. Si
veda la Licenza Pubblica Generica GNU per maggiori dettagli.

Questo programma deve essere distribuito assieme ad una copia della
Licenza Pubblica Generica GNU.


Questo software è stato sviluppato per l'uso interno nelle banche del tempo,
in particolare per la Banca del Tempo di Isola Vicentina(VI).

Il software è stato creato da zero, eventuali parti di codice copiate
e/o a cui l'autore si è ispirato sono da ritenersi rilasciate sotto la propria licenza,
in ogni caso i contenuti sono stati trovati sul web e/o su siti di dominio pubblico.

Nel caso si trovasse contenuto proprio, protetto da copyright, si prega di segnalarlo all'autore.
Ogni violazione di licenza da parte dell'autore è da ritenersi assolutamente non intenzionale.
Sviluppato con interamente con prodotti opensource e/o gratuiti.

Grafica basata su MaterializeCSS, un framework OpenSource rilasciato sotto licenza MIT, tutti i diritti relativi a http://materializecss.com/
Invio mail basato su PHPMailer, rilasciato sotto licenza LGPL, tutti i diritti relativi alla libreria ai rispettivi proprietari.

#REQUISITI per l'installazione:
-database MySQL >= 5.0 (consigliato almeno 5.4, potrebbe funzionare anche con versioni più vecchie ma successive alla 4.1)

-PHP >=5.4 ma inferiore a 7 (presenza di funzioni mysql non supportate)

-SMTP Server autenticato (non necessariamente quello del proprio hosting,anche gmail o altro provider, può rendersi necessaria qualche modifica alla funzione di invio mail(mailer_new) nella libreria(comuni/lib.php))

#INSTALLAZIONE:

-Iscriversi al servizio ReCaptcha e ottenere le chiavi per il proprio sito

-Ripristinare il database (documenti/openbdt.sql)

-Modificare e rinominare i file ESEMPIO.helpmail.html e comuni/ESEMPIO.config.php, che dovranno diventare, rispettivamente, helpmail.html e config.php (nel file helpmail è presente un link per generarlo, dopo aver inserito la mail che deve essere visualizzata nel sito per la richiesta di informazioni nei 2 campi premere 'Cloak it', quindi sostituire tutto il contenuto del file con ciò che è presente nel box a fondo pagina).

-Modificare il logo e la favicon(nella cartella principale e nella cartella comuni) con quelle della propria banca del tempo, rinominandole favicon.ico e logo.png. Sono presenti 2 immagini d'esempio, se si vogliono utilizzare vanno rinominate togliendo "ESEMPIO." davanti a ogni file.

-Caricare il proprio regolamento in pdf, rinominato in regolamento.pdf, all'interno della cartella documenti

-Al termine della procedura tutti i file che iniziano con "ESEMPIO" devono essere eliminati e sostituiti dall'equivalente senza "ESEMPIO.".

-Accedere con le credenziali di default,

	USER: admin

	PASSWORD: password

-Modificare le password dell'amministratore e creare i vari utenti
-Modificare i dati degli utenti di test attraverso PHPMyAdmin o equivalenti

-I 3 utenti predefiniti non vanno eliminati!!!!

#NOTE AGGIUNTIVE

La pagina categorie_public.php visualizza un elenco di tutte le abilità disponibili sulla piattaforma senza necessità di essere loggati(non viene mostrato nessun dato personale), è pensata per essere integrata in un sito esterno o su una pagina Facebook.

Il sito prevede anche un sistema di "tasse", quando il credito di un utente supera le 10 ore verrà tassato di un'ora ogni 5, ore che andranno all'utente  della Banca del Tempo.
I paramentri sono impostabili nel file config.php.

Il nome dell'account della Banca del tempo può essere modificato con PHPMyAdmin o direttamente nel file .sql da importare.

Il backup del database può essere automatizzato mediante la chiamata con un cronjob della pagina:

 		openbdt/bkp_db/backup.php?msg&key=chiavesegreta

La chiave può essere impostata all'interno del file config.php, senza il parametro msg la pagina in caso di esito positivo non darà nessun output.

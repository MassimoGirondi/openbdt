<?php
session_start(); // inizializzo la sessione
session_unset(); // svuoto l'array $_SESSION
session_destroy(); // distruggo la sessione

header("Location: ../index.php");
?>

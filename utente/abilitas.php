<?php
require("../comuni/lib.php");
autentica(UTENTE);
$titolo="Visualizza tutti le abilit&agrave;";
require("../comuni/header.php");
$abilitas=abilitas();

if($abilitas!=null){
?>
<br/>
    <?php
    /*<input id="testo" placeholder="Inserisci una parola chiave" type=text  />&nbsp;
    <input type=submit name=cmd value="Cerca" onclick="cerca2()"/><br/>*/?>
Cerca nelle colonne utente, categoria o descrizione digitando il testo in questa casella:<br/>
<input id="cercaabilita" placeholder="Inserisci una parola chiave" type=text onkeyup="cerca2()" /><br/>
<?php
/*
<table id="abilita">
	<tr>
		<td width="15%">Utente</td>
		<td  width="15%">Categoria</td>
		<td width="15%">Sub Categoria</td>
		<td width="25%">Note</td>
		<td width="15%">Mail</td>
                <td width="15%">Numero</td>
	</tr>

<?php
	while($s=mysql_fetch_row($abilitas))
	{
		?>		<tr>
				<td><?=$s[1]." ".$s[2]."(".$s[0].")"?></td>
                                <td><?=$s[3]?></td>
                                <td><?=$s[4]?></td>
                                <td><?=$s[5]?></td>
                                <td><?=$s[6]?></td>
                                <td><?=$s[7]?></td>
				</tr>
	
	<?php
	}
	
	?>
	</TABLE>

<?php*/

    $intest=array("Utente","Categoria","Sub Categoria","Note","Dettagli");
    $dim=array("20%","15%","15%","25%","15%","10%");
    $righe=array();
    while($s=mysql_fetch_row($abilitas))
    {
        //popup con alert:
    //$righe[]=array("$s[1] $s[2] ($s[0]) ","$s[3]",$s[4] ,$s[5],"<a onclick=\"dettagli_abilita($s[8])\" href=\"javascript:void(0);\">Dettagli</a>");
    
    //popup con modal
       // echo dettagli_abilita_modal($s[8]);
    $righe[]=array("$s[1] $s[2] ($s[0]) ","$s[3]",$s[4] ,$s[5],  dettagli_abilita_modal($s[8])."<a class=\"waves-effect waves-light btn modal-trigger\" href=\"#modal$s[8]\">Dettagli</a>");
    
    
    
    }
    agg_tabella($intest, $righe, $dim, "abilitas");


 ?>
<script>
  $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
  });
</script>
     <?php   
    
}
else {echo "Qui non c'&egrave; niente!";}
require("../comuni/footer.php");?>



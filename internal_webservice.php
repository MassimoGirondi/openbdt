<?php
if(isset($_REQUEST['s'])&&isset($_REQUEST['c']))
{
    $s=  intval($_REQUEST['s']);
    $c=  intval($_REQUEST['c']);
    if($c!=0 && $s!=0)
    {
        require ("comuni/lib.php");
        dbconnect();
    $r=explain_cat($c, $s);
    echo $r[0]."</td><td>".$r[1];
    
    }
}
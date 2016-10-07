<?php
require("../comuni/lib.php");
require("./FeedWriter.php");
dbconnect();
if(isset($_REQUEST['username'])&&isset($_REQUEST['password'])
        &&login(mysql_real_escape_string($_REQUEST['username']), mysql_real_escape_string($_REQUEST['password']))>0)
{                  
}
else
    autentica(ADMIN);

    //Creating an instance of FeedWriter class. 
    //The constant ATOM is passed to mention the version
    $TestFeed = new FeedWriter(ATOM);
    //Setting the channel elements
    //Use wrapper functions for common elements
    $TestFeed->setTitle("NEWS");
    $TestFeed->setLink($home);
    $TestFeed->setChannelElement('updated', date(DATE_ATOM , time()));
    $TestFeed->setChannelElement('author', $nomebdt);
    $ris= stampa_feed();
    while ($row = mysql_fetch_row($ris))
    {
            $newItem = $TestFeed->createNewItem();
            
            $newItem->setTitle(htmlentities($row[0]));
            $newItem->setLink($home);
            $newItem->setDate($row[2]);
            $newItem->setDescription(htmlentities($row[1]));
            $TestFeed->addItem($newItem);
    }
    
    
    
    //OK. Everything is done. Now genarate the feed.
    $TestFeed->genarateFeed();


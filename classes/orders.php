<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-18 Created classes folder and files
// Aafrin Sayani (2030150) 2022-04-19 Added plural class for orders.
// Aafrin Sayani (2030150) 2022-04-19 completed plural class orders.

require_once("collection.php");

class orders extends collection 
{
    function _contruct()
    {
        global $connection;
        
        $sql = "call order_all()";
        
        $PDOobject = $connection->prepare($sql);
        $PDOobject->execute();
        while($row = $PDOobject->fetch(PDO::FETCH_ASSOC))
        {
            $order = new product($row["order_id"],$row["description"], $row["qty_sold"],$row["sold_price"], $row["comments"],$row["c_id"], $row["p_id"]);
            $this->add($row["order_id"], $order);            
                    
        }
    }
}

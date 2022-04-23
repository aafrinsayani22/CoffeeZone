<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-18 Created classes folder and files
// Aafrin Sayani (2030150) 2022-04-18 Added plural class for products..
// Aafrin Sayani (2030150) 2022-04-18 completed plural class products

require_once("collection.php");

class products extends collection 
{
    function _contruct()
    {
        global $connection;
        
        $sql = "call product_all()";
        
        $PDOobject = $connection->prepare($sql);
        $PDOobject->execute();
        while($row = $PDOobject->fetch(PDO::FETCH_ASSOC))
        {
            $product = new product($row["product_code"],$row["description"], $row["price"],$row["cost_price"]);
            $this->add($row["product_code"], $product);            
                    
        }
    }
}

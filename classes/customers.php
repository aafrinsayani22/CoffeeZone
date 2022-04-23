<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-18 Created classes folder and files
// Aafrin Sayani (2030150) 2022-04-18 Added plural class for customers..
// Aafrin Sayani (2030150) 2022-04-18 completed plural class customers.

require_once("collection.php");

class customers extends collection 
{
    function _contruct()
    {
        global $connection;
        
        $sql = "call customer_all()";
        
        $PDOobject = $connection->prepare($sql);
        $PDOobject->execute();
        while($row = $PDOobject->fetch(PDO::FETCH_ASSOC))
        {
            $customer = new customer($row["customer_id"], $row["firstname"],$row["lastname"], $row["address"],
                    $row["city"], $row["province"],$row["postal_code"], $row["username"], $row["password"], $row["avatar"]);
            $this->add($row["customer_id"], $customer);            
                    
        }
    }
}

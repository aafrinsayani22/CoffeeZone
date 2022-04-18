<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require_once("collection.php");

class employees extends collection 
{
    function _contruct()
    {
        global $connection;
        
        $sql = "SELECT * FROM customers ORDER BY firstname";
        
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

<?php



/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
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

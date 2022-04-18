<?php



/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
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

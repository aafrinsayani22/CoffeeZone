<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once('connection.php'); #connection = new PDo

class product {

    const PRODUCT_ID_MAX_LENGTH = 12;
    const PRODUCT_CODE_MAX_LENGTH = 12;
    const DESCRIPTION_MAX_LENGTH = 100;
    const PRICE_MAX_LENGTH = 1000;
    const COST_PRICE_MAX = 200;



    private $product_id = "";
    private $product_code = "";
    private $description = "";
    private $price = "";
    private $cost_price = "";

 
    
    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getCost_price() {
        return $this->cost_price;
    }


   

    public function setDescription($newDescription) {

        if (mb_strlen($newDescription) == 0) {
            return "The product code is empty.";
        }
        if (mb_strlen($newDescription) > self::DESCRIPTION_MAX_LENGTH) {
            return "The product code must be less than 20.";
        }
        else {
            $this->description = $newDescription;
        }
    }
    
    public function setPrice($newPrice) {

        if (mb_strlen($newPrice) == 0) {
            return "The newDescription is empty.";
        } 
        if (mb_strlen($newPrice) > self::PRICE_MAX_LENGTH) {
            return "The newDescription must be less than 20 char";
        } 
        else {
            $this->price = $newPrice;
        }
    }
    
    public function setCost_price($newCost_price) {

        if (mb_strlen($newCost_price) == 0) {
            return "The price is empty. ";
        }
        if (mb_strlen($newCost_price) > self::COST_PRICE_MAX) {
            return "The price must be less than 25";
        }
        else {
            $this->cost_price = $newCost_price;
        }
    }
    
    public function _construct( $description, $price, $cost_price) {
 
        
        if ($description != "") {
            $this->description($description);
        }
        
        if ($price != "") {
            $this->price($price);
        }
        if ($cost_price != "") {
            $this->cost_price($cost_price);
        }
 
    }

    public function load($product_code) {
        global $connection;

        $sql = "CALL product_select(:product_code)";

        $PDOobject = $connection->prepare($sql);
        $PDOobject->bindParam(':product_code', $product_code);
        $PDOobject->execute();

        if ($row = $PDOobject->fetch(PDO::FETCH_ASSOC)) {
            $this->description = $row["description"];
            $this->price = $row["price"];
            $this->cost_price = $row["cost_price"];
       
            return true;
        }
    }

    public function save() {

        global $connection;

        if (($this->description != "")&& ($this->price != "") && ($this->cost_price != ""))
        {
            $sql = "call product_insert(:product_code, :description, :price, :cost_price)";
        
            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':product_code', $this->product_code);
            $PDOobject->bindParam(':description', $this->description);
            $PDOobject->bindParam(':price', $this->price);
            $PDOobject->bindParam(':cost_price', $this->cost_price);
   
            $PDOobject->execute();
            return true;
        }
        else
        {
           $sql =  "call product_update(:product_code, :description, :price, :cost_price)";

            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':product_code', $this->product_code);
            $PDOobject->bindParam(':description', $this->description);
            $PDOobject->bindParam(':price', $this->price);
            $PDOobject->bindParam(':cost_price', $this->cost_price);
            $PDOobject->execute();
            
            return true;
        }


    }
    
        public function delete() {

        global $connection;

        if ($this->product_code != "") {
            
            $sql = "call product_delete(:product_code)";

            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':product_code', $this->product_code);
            $PDOobject->execute();
            return true;
        }

    }

}

<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once('connection.php'); #connection = new PDo

class customer {

    const PRODUCT_ID_MAX_LENGTH = 12;
    const PRODUCT_CODE_MAX_LENGTH = 12;
    const DESCRIPTION_MAX_LENGTH = 100;
    const PRICE_MAX = 10000;
    const COST_PRICE_MAX_LENGTH = 10000;


    private $product_id = "";
    private $product_code = "";
    private $description = "";
    private $price = "";
    private $cost_price = "";
 
    
    public function getProduct_code() {
        return $this->product_code;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }
    
    public function getCostPrice() {
        return $this->cost_price;
    }

   

    public function setProduct_code($newProductcode) {

        if (mb_strlen($newProductcode) == 0) {
            return "The product code is empty.";
        }
        if (mb_strlen($newProductcode) > self::PRODUCT_CODE_MAX_LENGTH) {
            return "The product code must be less than 20.";
        }
        else {
            $this->product_code = $newProductcode;
        }
    }
    
    public function setDescription($newDescription) {

        if (mb_strlen($newDescription) == 0) {
            return "The newDescription is empty.";
        } 
        if (mb_strlen($newDescription) > self::DESCRIPTION_MAX_LENGTH) {
            return "The newDescription must be less than 20 char";
        } 
        else {
            $this->description = $newDescription;
        }
    }
    
    public function setPrice($newPrice) {

        if (mb_strlen($newPrice) == 0) {
            return "The price is empty. ";
        }
        if (mb_strlen($newPrice) > self::PRICE_MAX) {
            return "The price must be less than 25";
        }
        else {
            $this->price = $newPrice;
        }
    }
    
    public function setCost_price($newCostprice) {

        if (mb_strlen($newCostprice) == 0) {
            return "The cost price is empty";
        }
        
        if (mb_strlen($newCostprice) > self::COST_PRICE_MAX_LENGTH) {
            return "The cost price must be less than 25 ";
        }
        else {
            $this->cost_price = $newCostprice;
        }
    }

    
 

    public function _construct( $product_code, $description, $price, $cost_price) {
 
        
        if ($product_code != "") {
            $this->product_code($product_code);
        }
        
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
        $PDOobject->bindParam(':producyt_code', $product_code);
        $PDOobject->execute();

        if ($row = $PDOobject->fetch(PDO::FETCH_ASSOC)) {
            $this->product_code = $row["prod_code"];
            $this->description = $row["description"];
            $this->price = $row["price"];
            $this->cost_price = $row["cost_price"];

            return true;
        }
    }

    public function save() {

        global $connection;

        if (($this->product_code != "")&& ($this->description != "") && ($this->price != "") && ($this->cost_price != ""))
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

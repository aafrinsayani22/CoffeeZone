<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once('connection.php'); #connection = new PDo

class order {

    const ORDER_ID_MAX_LENGTH = 36;
    const QUANTITY_SOLD_MAX_LENGTH = 999;
    const SOLD_PRICE_MAX_LENGTH = 1000;
    const COMMENTS_MAX = 200;
    const CUSTOMER_ID_MAX_LENGTH = 36;
    const PRODUCT_ID_MAX_LENGTH = 12;


    private $order_id = "";
    private $quantity_sold = 0;
    private $sold_Price = "";
    private $comments = "";
    private $customer_id = "";
    private $product_id = "";
 
    
    public function getQuantity_sold() {
        return $this->quantity_sold;
    }

    public function getSoldprice() {
        return $this->sold_Price;
    }

    public function getComment() {
        return $this->comments;
    }
    
    public function getCustomerid() {
        return $this->customer_id;
    }
    public function getProductid() {
        return $this->product_id;
    }

   

    public function setQuantity_sold($newQuantity) {

        if (mb_strlen($newQuantity) == 0) {
            return "The product code is empty.";
        }
        if (mb_strlen($newQuantity) > self::QUANTITY_SOLD_MAX_LENGTH) {
            return "The product code must be less than 20.";
        }
        else {
            $this->quantity_sold = $newProductcode;
        }
    }
    
    public function setSold_price($newSold_price) {

        if (mb_strlen($newSold_price) == 0) {
            return "The newDescription is empty.";
        } 
        if (mb_strlen($newSold_price) > self::SOLD_PRICE_MAX_LENGTH) {
            return "The newDescription must be less than 20 char";
        } 
        else {
            $this->sold_Price = $newSold_price;
        }
    }
    
    public function setComment($newComment) {

        if (mb_strlen($newComment) == 0) {
            return "The price is empty. ";
        }
        if (mb_strlen($newComment) > self::COMMENTS_MAX) {
            return "The price must be less than 25";
        }
        else {
            $this->comments = $newComment;
        }
    }
    
  

    
 

    public function _construct( $quantity_sold, $sold_price, $comments, $customer_id, $product_id) {
 
        
        if ($quantity_sold != "") {
            $this->quantity_sold($product_code);
        }
        
        if ($sold_price != "") {
            $this->sold_Price($description);
        }
        if ($comments != "") {
            $this->comments($price);
        }
        if ($customer_id != "") {
            $this->customer_id($price);
        }
        if ($product_id != "") {
            $this->product_id($cost_price);
        }
        
    }

    public function load($order_id) {
        global $connection;

        $sql = "CALL order_select(:order_id)";

        $PDOobject = $connection->prepare($sql);
        $PDOobject->bindParam(':order_id', $order_id);
        $PDOobject->execute();

        if ($row = $PDOobject->fetch(PDO::FETCH_ASSOC)) {
            $this->order_id = $row["order_id"];
            $this->quantity_sold = $row["qty_sold"];
            $this->sold_price = $row["sold_price"];
            $this->comments = $row["comments"];

            return true;
        }
    }

    public function save() {

        global $connection;

        if (($this->quantity_sold != "")&& ($this->sold_Price != "") && ($this->comments != ""))
        {
            $sql = "call order_insert(:quantity_sold, :sold_Price, :comments)";
        
            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':quantity_sold', $this->quantity_sold);
            $PDOobject->bindParam(':sold_price', $this->sold_Price);
            $PDOobject->bindParam(':comments', $this->comments);
           
   
            $PDOobject->execute();
            return true;
        }
        else
        {
           $sql =  "call product_update(:sold_price, :comments, :sold_price)";

            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':sold_price', $this->sold_Price);
            $PDOobject->bindParam(':comments', $this->comments);
            $PDOobject->bindParam(':sold_price', $this->sold_Price);
            $PDOobject->execute();
            
            return true;
        }


    }
    
        public function delete() {

        global $connection;

        if ($this->order_id != "") {
            
            $sql = "call order_delete(:order_id)";

            $PDOobject = $connection->prepare($sql);
            $PDOobject->bindParam(':order_id', $this->order_id);
            $PDOobject->execute();
            return true;
        }

    }

}

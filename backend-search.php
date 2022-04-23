<?php


require_once './config.php';
require_once './functions/phpfunction.php';

session_start();
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

 
// Attempt search query execution
try{
    if(isset($_REQUEST["term"])){
        // create prepared statement
       //$sql = "call orders_search(:term, :c_id)";
        $sql = "SELECT * FROM products WHERE customer_id = :c_id AND  DATE(created) <= :term";
        $stmt = $pdo->prepare($sql);
        $term = $_REQUEST["term"] . '%';
        // bind parameters to statement
        $stmt->bindParam(":term", $term);
        //$stmt->bindParam(":c_id", $_SESSION["id"]);
        $stmt->bindParam(":c_id", $p_c_id);
        $P_c_id = $_SESSION["id"];
        // execute the prepared statement
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){ 
               table($row); 
                   
              
            }
        } else{
            echo "<p>No matches found</p>";
        }
    }  
} catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
 
// Close statement
unset($stmt);
 
// Close connection
unset($pdo);
?>
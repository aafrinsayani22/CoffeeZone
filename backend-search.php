<?php


require_once './config.php';
require_once './functions/phpfunction.php';

session_start();
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

 
// Attempt search query execution
try{
    if(isset($_POST["date"])){
        // create prepared statement
       //$sql = "call orders_search(:term, :c_id)";
        $sql = "SELECT * FROM orders JOIN products on orders.p_id = products.product_id JOIN customers on customers.customer_id = orders.c_id WHERE  DATE(orders.created) >= :term";
        $stmt = $connection->prepare($sql);
        $term = $_POST["date"] . '%';
        // bind parameters to statement
        $stmt->bindParam(":term", $term);
        //$stmt->bindParam(":c_id", $_SESSION["id"]);
        //$stmt->bindParam(":c_id", $p_c_id);
        $P_c_id = $_SESSION["id"];
        // execute the prepared statement
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){ 
                ?>
            }
              <tr class='table-row'>

        <td><?php echo $row['created']; ?></td>
        <td><?php echo $row['prod_code']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
        <td><?php echo $row['city']; ?></td>
        <td><?php echo $row['comments']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['qty_sold']; ?></td>
        <td><?php echo $row['sub_total']; ?></td>
        <td><?php echo $row['taxes_amount']; ?></td>
        <td><?php echo $row['total']; ?></td>
        <td><a href="delete.php?id='<?php $_SESSION["id"] ?>" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash">delete</span></a></td>
    </tr> 
                   
           <?php   
            }
        } else{
            echo "<p>No matches found</p>";
        }
    }
    else if(empty ($_POST["term"]))
    {
        // create prepared statement
       //$sql = "call orders_search(:term, :c_id)";
        $sql = "SELECT * FROM orders JOIN products on orders.p_id = products.product_id JOIN customers on customers.customer_id = orders.c_id WHERE  orders.c_id = :p_c_id";
        $stmt = $connection->prepare($sql);
        //$term = $_REQUEST["term"] . '%';
        // bind parameters to statement
          $p_c_id = $_SESSION["id"];
        $stmt->bindParam(":p_c_id", $p_c_id);
        //$stmt->bindParam(":c_id", $_SESSION["id"]);
        //$stmt->bindParam(":c_id", $p_c_id);
      
        // execute the prepared statement
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch()){ 
                ?>
            }
              <tr class='table-row'>

        <td><?php echo $row['created']; ?></td>
        <td><?php echo $row['prod_code']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
        <td><?php echo $row['city']; ?></td>
        <td><?php echo $row['comments']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['qty_sold']; ?></td>
        <td><?php echo $row['sub_total']; ?></td>
        <td><?php echo $row['taxes_amount']; ?></td>
        <td><?php echo $row['total']; ?></td>
        <td><a href="delete.php?id='<?php $row["order_id"] ?>" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash">delete</span></a></td>
    </tr> 
                   
           <?php 
           $order_id = $row["order_id"];
           echo $order_id;
                   
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
unset($connection);
?>
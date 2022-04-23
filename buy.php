
<?php
session_start();
require_once './config.php';

require_once './classes/product.php';
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call
// Page Structure
//noCache();
// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Buy Page");
if(!isset($_SESSION["id"]))
{
     session();
     exit;
}
else
{
    session();
    

}

?>

<?php
// Check if the user is already logged in, if yes then redirect him to welcome page
//if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true) {
//    header("location: login.php");
//    exit;
//}

// Include config file


// Define variables and initialize with empty values
$quantity = $comment = "";
$quantity_err = $comment_err = "";


// Include config fil

// Attempt select query execution
$sql = "CALL product_all()";
if ($result = $connection->query($sql)) {
    if ($result->rowCount() > 0) {

        echo '<label for="Products">Choose Product:</label>';
        echo '<select name="product" id="cars">';
       
        while ($row = $result->fetch()) {

            $prod_id = $row['product_id'];
            echo "<option value='" . $row['product_id'] . "'>" . $row['prod_code'] . "-" . $row['description'] . " (" . $row['price'] . "$)" . "</option>";
        }
        echo "</select>";

        //INSERT into orders
        // Free result set
        unset($result);
    } else {
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
} else {
    echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
//unset($connection);
?>



<?php

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(htmlspecialchars($_POST["quantity"]))) {
        $quantity_err = "Please enter quantity.";
    } else if(!($_POST["quantity"] > 1 || $_POST["quantity"] < 99)) {
        $quantity_err = "Please enter valid quantity(1-99)";
    }
    else {
        $quantity = htmlspecialchars($_POST["quantity"]);
    }

    // Check if password is empty
    if (empty(htmlspecialchars($_POST["comment"]))) {
        $comment_err = "Please enter your comment.";
    } else {
        $comment = htmlspecialchars($_POST["comment"]);
    }

    // Validate credentials
    if (empty($quantity_err) && empty($comment_err)) {
        
        
        $product = new product();
        $product->load($prod_id);
        
        $price = $product->getPrice();
       
        
        $quantity = $_POST["quantity"];
        
        $subtotal = floatval($price) * $quantity;
        $taxesAmount = $subtotal  * 13.7/100;
        
        $total = $subtotal + $taxesAmount; #this gives 211.563
                
        $sql = "INSERT INTO orders( qty_sold, sold_price, comments, c_id, p_id, sub_total, taxes_amount, total) VALUES( :qty_sold, :sold_price, :comments, :c_id, :p_id, :sub_total, :taxes_amount, :total)";


        // Prepare a select statement
        //$sql = "CALL order_insert(:qty_sold, :sold_price, :comments, :c_id, :p_id, :sub_total, :taxes_amount, :total)";

        if ($PDOobject = $connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $PDOobject->bindParam(":qty_sold", $p_quantity, PDO::PARAM_STR);
            $PDOobject->bindParam(":sold_price", $p_sold_price, PDO::PARAM_STR);
            $PDOobject->bindParam(":comments", $p_comments, PDO::PARAM_STR);
            $PDOobject->bindParam(":c_id", $p_c_id, PDO::PARAM_STR);
            $PDOobject->bindParam(":p_id", $p_p_id, PDO::PARAM_STR);
            $PDOobject->bindParam(":sub_total", $p_subtotal, PDO::PARAM_STR);
            $PDOobject->bindParam(":total", $p_total, PDO::PARAM_STR);
            $PDOobject->bindParam(":taxes_amount", $p_taxes_amount, PDO::PARAM_STR);

            // Set parameters
            $p_sold_price = $price;
            $p_quantity = htmlspecialchars($_POST["quantity"]);
            $p_comments = htmlspecialchars($_POST["comment"]);
            $p_p_id = $prod_id;
            $p_c_id = $_SESSION["id"];
            $p_subtotal = $subtotal;
            $p_total = $total;
            $p_taxes_amount = $taxesAmount;

            // Attempt to execute the prepared statement
            if ($PDOobject->execute()) {
                
                echo "Product added successfully!";
                
            } else {
                echo "Oops! Something went wrong . Please try again later.";
            }

            
        }
        // Close statement
        unset($PDOobject);
    }

    // Close connection
    unset($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>

    </head>
    <body>
        <div class="Container-form" style="background-color: #39b2c4;">
            <h2>Buy</h2>
            <p>Choose Items.</p>

            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <span class="error">*  <?php echo $quantity_err ?></span>
                <label>Quantity</label>
                <input type="text" name="quantity"  value="<?php //echo $quantity; ?>">
                <br><br>

                <span class="error">*  <?php echo $comment_err ?></span>
                <label>Comment</label>
                <input type="text" name="comment" value="<?php  // echo $comment; ?> ">


                <div class="">
                    <input type="submit" style="background-color: #1d5962; margin-bottom: 2px;"  value="Buy">
                </div>
       
            </form>
        </div>
    </body>
</html>



<?php

session_start();
// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-20 added file and intialized.
// Aafrin Sayani (2030150) 2022-04-20 Addes html to generate form
// Aafrin Sayani (2030150) 2022-04-20 Added css
// Aafrin Sayani (2030150) 2022-04-20 Populated product data into database
// Aafrin Sayani (2030150) 2022-04-21  Added logic to retrieve the products from the database
// Aafrin Sayani (2030150) 2022-04-21 Added extra  feilds into the database
// Aafrin Sayani (2030150) 2022-04-21 Added objects connection to manipulate with database
// Aafrin Sayani (2030150) 2022-04-21 Prevented agaiinst sql injection.
// Aafrin Sayani (2030150) 2022-04-21 Added session and tested
// Aafrin Sayani (2030150) 2022-04-23 Finalized Buy page.
// Including common functionce file
include_once('functions/phpfunction.php');

// Page Structure
noCache();

// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Buy Page");

if (!isset($_SESSION["id"])) {
    checkLogin();
    exit;
} else {
    checkLogin();
}
// Define variables and initialize with empty values
$quantity = $comment = $prod_id = "";
$quantity_err = $comment_err = "";
$price = $p_price = $sub_total = $taxesAmount = 0.00;

// Attempt select query execution ot retrieve all the products from the database
$sql = "CALL product_all()";
if ($result = $connection->query($sql)) {
    if ($result->rowCount() > 0) {
        $product = new product();
        // print the dropdown list.
        echo '<label for="Products">Choose Product:</label>';
        echo '<select name="product" id="cars">';

        // fetch the data to list products
        while ($row = $result->fetch()) {

            echo "<option value='" . $row['product_id'] . "'>" . $row['prod_code'] . "-" . $row['description'] . " (" . $row['price'] . "$)" . "</option>";
            $prod_id = $row["product_id"];
        }
        echo "</select>";
//$product->load($row['product_id']);
//$price = $product->getPrice();
   
        // Free result set
        unset($result);
    } else {
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
} else {
    echo "Oops! Something went wrong. Please try again later.";
}



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate input fields
    // Create order and product object 
    $order = new order();
    $product = new product();
    // Check if quantity is allowed
    if (empty(htmlspecialchars($_POST["quantity"]))) {
        $quantity_err = $order->setQuantity_sold($_POST["quantity"]);
    }
    if (htmlspecialchars($_POST["quantity"])) {
        $comment_err = $order->setComment($_POST["comment"]);
    } else {

        $order->setComment(htmlspecialchars($_POST["comment"]));
        $order->setQuantity_sold(htmlspecialchars($_POST["quantity"]));
    }

    // Validate credentials
    if (empty($quantity_err)) {

        $product = $product->load($prod_id);
        $sql = "select * from products where product_id = :product_id";

        $PDOobject = $connection->prepare($sql);
        $PDOobject->bindParam(':product_id', $prod_id);
        $PDOobject->execute();

        if ($row = $PDOobject->fetch(PDO::FETCH_ASSOC)) {

            $p_price = $row["price"];
        }

        $quantity = htmlspecialchars($_POST["quantity"]);
        $comment = htmlspecialchars($_POST["comment"]);

        $subtotal = floatval($p_price) * $_POST["quantity"];
        $taxesAmount = floatval($subtotal) * (13.7 / 100);
        $total = $subtotal + $taxesAmount; #this gives 211.563
        //$sql = "CALL order_insert(:qty_sold, :sold_price, :comments, :c_id, :p_id, :sub_total, :taxes_amount, :total)" ;      
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
            $p_sold_price = $p_price;
            $p_quantity = $_POST["quantity"];
            $p_comments = $order->getComment();
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

buyForm($quantity, $comment, $prod_id, $quantity_err, $comment_err);
?>

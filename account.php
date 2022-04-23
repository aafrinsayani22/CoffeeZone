
<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-20 added file and intialized.
// Aafrin Sayani (2030150) 2022-04-20 generated basic html, added css, session.
// Aafrin Sayani (2030150) 2022-04-20 Populated product data into database
// Aafrin Sayani (2030150) 2022-04-21  Added logic to retrieve the products from the database
// Aafrin Sayani (2030150) 2022-04-21 Added extra  feilds into the database
// Aafrin Sayani (2030150) 2022-04-22 Added objects and mehtods.
// Aafrin Sayani (2030150) 2022-04-22 Added session and tested, prevented html injection and sql injection.
// Aafrin Sayani (2030150) 2022-04-22 Finalized Buy page.

session_start();

// Include config file
require_once "config.php";
//require_once './pictures';


require_once './classes/customer.php';
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call
// Page Structure
// Navigation Bar function call
   navigationMenu();

// Top Page function call
PageTop("Sign-Up Page");

if(!isset($_SESSION["id"]))
{
    checkLogin();
     exit;
}
else
{
    checkLogin();

}

?>

<?php
// Include config file
// Define variables and initialize with empty values
$username = $avatar = $password = $firstname = $lastname = $province= $address = $city = $postal_code = "";
$firstname_err = $lastname_err = $address_err = $city_err = $postal_code_err = $avatar_err = "";
$username_err = $password_err = "";
$avatar = NULL;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get teh file content
        if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
       // $customer->setAvatar($avatar);
        
    } else {
        $avatar_err = "please upload a file";
    }
    // Get hidden input value
    $id = $_SESSION["id"];

    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $address = htmlspecialchars($_POST["address"]);
    $city = htmlspecialchars($_POST["city"]);
    $postal_code = htmlspecialchars($_POST["postal_code"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    // Validate input fields
    // Create customer objct
    $customer = new customer();
    //check if the user name  exists in the database or not
    if (empty($_POST["avatar"])) {
        $avatar_err = $customer->setAvatar($avatar);
    }
    if (empty(htmlspecialchars($_POST["firstname"]))) {
        $firstname_err = $customer->setFirstname($firstname);
    }
    if (empty(htmlspecialchars($_POST["lastname"]))) {
        $lastname_err = $customer->setLastname($lastname);
    } else if (empty(htmlspecialchars($_POST["address"]))) {
        $address_err = $customer->setAddress($address);
    } else if (empty(htmlspecialchars($_POST["city"]))) {
        $city_err = $customer->setCity($city);
    } else if (empty(htmlspecialchars($_POST["postal_code"]))) {
        $postal_code_err = $customer->setPostal_code($postal_code);
    } else if (empty(htmlspecialchars($_POST["username"]))) {
        $username_err = $customer->setUsername($username);
    } else if (empty(htmlspecialchars($_POST["password"]))) {
        $password_err = $customer->setPassword($password);
    } else {
        $customer->_construct($firstname, $lastname, $address, $city, $province, $postal_code, $username, $password, $avatar);

        // Check input errors before inserting in database
        if (empty($username_err) && empty($password_err) && empty($firstname_err) && empty($lastname_err) && empty($address_err) && empty($city_err) && empty($postal_code_err)) {
            // Prepare an update statement
            //$sql = "CALL customer_update(:firstname, :lastname, :address,:city, :postal_code, :username,:password, :avatar ,:customer_id)";
            $sql = "UPDATE customers SET firstname=:firstname, lastname=:lastname, address=:address, city=:city, postal_code=:postal_code, username=:username, password=:password, avatar=:avatar WHERE customer_id=:customer_id";

            if ($stmt = $connection->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":firstname", $p_firstname, PDO::PARAM_STR);
                $stmt->bindParam(":lastname", $p_lastname, PDO::PARAM_STR);
                $stmt->bindParam(":address", $p_address, PDO::PARAM_STR);
                $stmt->bindParam(":city", $p_city, PDO::PARAM_STR);
                $stmt->bindParam(":postal_code", $p_postal_code, PDO::PARAM_STR);
                $stmt->bindParam(":username", $p_username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $p_password, PDO::PARAM_STR);
                $stmt->bindParam(":customer_id", $p_customer_id);
                $stmt->bindParam(":avatar", $p_avatar, PDO::PARAM_STR);

                // Set parameters

                $p_firstname = $customer->getFirstname();
                $p_lastname = $customer->getLastname();
                $p_address = $customer->getAddress();
                $p_city = $customer->getCity();
                $p_postal_code = $customer->getPostal_code();
                $p_username = $$customer->getUsername();
                $p_password = password_hash($customer->getPassword(), PASSWORD_DEFAULT);
                $p_customer_id = $id;
                $p_avatar= $avatar;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Records updated successfully. Redirect to landing page
                    //header("location: index.php");
                    echo "Updated successfully";
                    //exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            unset($stmt);
        }
    }
    // Close connection
    unset($pdo);
} else {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

        // Check existence of id parameter before processing further
        //if(isset($_GET["id"]) && !empty(htmlspecialchars($_GET["id"]))){
        // Get URL parameter
        $id = $_SESSION["id"];

        // Prepare a select statement
        $sql = "CALL customer_select(:id)";
        //$sql = "SELECT * FROM customers WHERE customer_id = :id";
        if ($stmt = $connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    /* Fetch result row as an associative array. Since the result set
                      contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Retrieve individual field value
                    $firstname = $row["firstname"];
                    $lastname = $row["lastname"];
                    $address = $row["address"];
                    $city = $row["city"];
                    $postal_code = $row["postal_code"];
                    $username = $row["username"];
                    $password = "";
                    
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        unset($connection);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
//        header("location: login.php");
//        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update Record</title>
        <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                .wrapper{
                    width: 600px;
                    margin: 0 auto;
                }
            </style>-->
    </head>
    <body>
        <section class="section-how" id="how">
            <div class="container">
                <!--          <h2 class="heading-primary" style="margin-bottom: 2.5rem">
                            Welcome Folk
                          </h2>
                          <h1 class="heading-secondary">Please Create New account with your personal account information.</h1>-->
            </div>
            <div class="container grid grid--2-cols-reg grid--center-v">
                <!-- STEP 02 -->
                <div class="step-img-box">
                    <embed src="./undraw_updates_re_o5af.svg" />
                </div>
                <div class="step-text-box">
                    <div class="form" style="
                         /*box-sizing: border-box;*/

                         ">

                        <div class="Container-form" style="background-color: #39b2c4;">
              <!--          <p><span class="error" style="color: red; ">* Required field</span></p>-->
                            <h2>Update Record</h2>
                            <p>Please edit the input values and submit to update the  record.</p>

                            <form enctype="multipart/form-data" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                                <div class="">
                                    <label>Firstname</label>
                                     <span class="error">*   <?php echo $firstname_err ?></span>
                                    <input type="text" name="firstname"  value="<?php echo $firstname; ?>">
                                   
                                </div>
                                <div class="">
                                    <label>Lastname</label>
                                      <span class="error">*  <?php echo $lastname_err; ?></span>
                                    <input type="text" name="lastname" value="<?php echo $lastname; ?>">
                                  
                                </div>
                                <div class="">
                                    <label>Address</label>
                                    <span class="error">*  <?php echo $address_err; ?></span>
                                    <input type="text" name="address"  value="<?php echo $address; ?>">
                                    
                                </div>
                                <div class="">
                                    <label>City</label>
                                      <span class="error">*  <?php echo $city_err; ?></span>
                                    <input type="text" name="city" value="<?php echo $city; ?>">
                                  
                                </div>
                                <div class="">
                                    <label>Postal Code:</label>
                                    <span class="error">*  <?php echo $postal_code_err; ?></span>
                                    <input type="text" name="postal_code"  value="<?php echo $postal_code; ?>">
                                
                                </div>
                                <div class="">
                                    <label>Username</label>
                                    <span class="error">*  <?php echo $username_err; ?></span>
                                    <input type="text" name="username"  value="<?php echo $username; ?>">
                 
                                </div>
                                <div class="">
                                    <label>Password</label>
                                        <span class="error">*  <?php echo $password_err; ?></span>
                                    <input type="password" name="password"  value="<?php echo $password; ?>">
                                
                                </div>

                                <label>Picture</label>
                                <span class="error">*  <?php echo $avatar_err ?></span>
                                <br>
                                <input type="file" name="avatar" value="<?php // echo $avatar;  ?>">
                                <br><br>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                <input type="submit" style="background-color: #1d5962; margin: 5px;"" value="Submit">
        <!--                        <input href="index.php" style="background-color: #1d5962; margin: 5px;" class="btn1" value ="Cancel">-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>      

        </div>
    </div>
</section>
</body>
</html>
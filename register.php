<?php


// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-19 added file and intialized.
// Aafrin Sayani (2030150) 2022-04-19 generated basic html, added css, session.
// Aafrin Sayani (2030150) 2022-04-20 woked on the logic
// Aafrin Sayani (2030150) 2022-04-20 handeled errors.
// Aafrin Sayani (2030150) 2022-04-20 prevented HTLML injection
// Aafrin Sayani (2030150) 2022-04-20 inserted data, added avatar, create password hash, image stroing.
// Aafrin Sayani (2030150) 2022-04-23 Added objects and mehtods.
// Aafrin Sayani (2030150) 2022-04-23 Prevented sql injection.
// Aafrin Sayani (2030150) 2022-04-23 Finalized register page.

// Include config file
require_once "config.php";


require_once './classes/customer.php';

// Including common functions file
include_once('functions/phpfunction.php');

// Navigation Bar function call
// Page Structure
// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Sign-Up Page");
if(isset($_SESSION["id"]))
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
//Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: login.php");
//    exit;
//}
// Define variables and initialize with empty values

$username= $avatar = $password = $firstname = $lastname = $address = $city = $postal_code = $province = "";
$firstname_err = $lastname_err = $address_err = $city_err = $postal_code_err = $avatar_err= "";
$username_err = $password_err = "";
$avatar = NULL;

// Processing form data when form is submitted
if (isset($_POST["signup"])) {

    if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
       // $customer->setAvatar($avatar);
        
    } else {
        $avatar_err = "please upload a file";
    }
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
    if (empty(htmlspecialchars($_POST["firstname"]))) {
        $firstname_err = $customer->setFirstname($firstname);
    }
    if (empty($_POST["avatar"])) {
        $avatar_err = $customer->setAvatar($avatar);
    }

    if (empty(htmlspecialchars($_POST["lastname"]))) {
        $lastname_err = $customer->setLastname($lastname);
    }
    if (empty(htmlspecialchars($_POST["address"]))) {
        $address_err = $customer->setAddress($address);
    }
    if (empty(htmlspecialchars($_POST["city"]))) {
        $city_err = $customer->setCity($city);
    }
    if (empty(htmlspecialchars($_POST["postal_code"]))) {
        $postal_code_err = $customer->setPostal_code($postal_code);
    }
    if (empty(htmlspecialchars($_POST["username"]))) {
        $username_err = $customer->setUsername($username);
    }
    if (empty(htmlspecialchars($password))) {
        $password_err = $customer->setPassword($password);
    }
// if all the fields are not empty and setted,  prepare to manipulate data with sql
    else {

        // Prepare a select statement with username provided to check if the username already exists.
        $sql = "CALL customer_select(:username)";
        //$sql = "SELECT * FROM customers WHERE username = :username";

        if ($PDOobject = $connection->prepare($sql)) {

            // Bind variables to the prepared statement as parameters
            $PDOobject->bindParam(":username", $p_username, PDO::PARAM_STR);

            // Set parameters
            $p_username = $username;

            // Eexecute the prepared statement
            if ($PDOobject->execute()) {
                if ($PDOobject->rowCount() == 1) {
                    $username_err = "Try different username.";
                } else {
                    // Store the value into customer object of the given username.
                    $customer->_construct($firstname, $lastname, $address, $city, $province, $postal_code, $username, $password, $avatar);
                }
            } else {
                echo "Oops! Something went wrong with the connection. Please try again later.";
            }

            // Close statement
            unset($PDOobject);
        }
    }



    // Check if error strings are empty before inserting in database
    if (empty($username_err) && empty($password_err) && empty($firstname_err) && empty($lastname_err) && empty($address_err) && empty($city_err) && empty($postal_code_err) && empty($postal_code_err)  && empty($avatar_err)){

        // Prepare sql query
        //$sql = "INSERT INTO customers (firstname,lastname,address,city,postal_code,username, password) VALUES (:firstname,:lastname,:address,:city,:postal_code,:username,:password)";
    
        $sql = "CALL customer_insert(:firstname, :lastname, :address, :city, :postal_code, :username, :password, :avatar)";
        if ($PDOobject = $connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters

            $PDOobject->bindParam(":firstname", $p_firstname, PDO::PARAM_STR);
            $PDOobject->bindParam(":lastname", $p_lastname, PDO::PARAM_STR);
            $PDOobject->bindParam(":address", $p_address, PDO::PARAM_STR);
            $PDOobject->bindParam(":city", $p_city, PDO::PARAM_STR);
            $PDOobject->bindParam(":postal_code", $p_postal_code, PDO::PARAM_STR);
            $PDOobject->bindParam(":username", $p_username, PDO::PARAM_STR);
            $PDOobject->bindParam(":password", $p_password, PDO::PARAM_STR);
            $PDOobject->bindParam(":avatar", $p_avatar, PDO::PARAM_STR);

            // Set parameters
         
            $p_firstname = $customer->getFirstname();
            $p_lastname = $customer->getLastname();
            $p_address = $customer->getAddress();
            $p_city = $customer->getCity();
            $p_postal_code = $customer->getPostal_code();
            $p_username = $customer->getUsername();
            $p_avatar = $customer->getAvatar();
            $p_password = password_hash($customer->getPassword(), PASSWORD_DEFAULT); // Creates a password hash
 
            // Attempt to execute the prepared statement
            if ($PDOobject->execute()) {
                //Redirect to login page
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($PDOobject);
        }
    }

    // Close connection
    unset($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>

    </head>
    <body>
        <section class="section-how" id="how">
            <div class="container">
                <h2 class="heading-primary" style="margin-bottom: 2.5rem">
                    Welcome Folk
                </h2>
                <h1 class="heading-secondary">Please Create New account with your personal account information. </h1>
            </div>

            <div class="container grid grid--2-cols-reg grid--center-v">
                <!-- STEP 02 -->
                <div class="step-img-box">
                    <embed src="undraw_profile-register.svg" />
                </div>


                <div class="step-text-box">
                    <div class="form" style="
                         /*box-sizing: border-box;*/
                         
                         ">

                        <div class="Container-form" style="background-color: #39b2c4;">
                            <p><span class="error" style="color: red; ">* Required field</span></p>
                            <h2>Sign Up</h2>
                            <p>Please fill this form to create an account.</p>
                            <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                <label>Firstname</label>
                                <span class="error">*  <?php echo $firstname_err ?></span>
                                <input type="text" name="firstname"  value="<?php echo $firstname; ?>">
                                <br><br>



                                <label>Lastname</label>
                                <span class="error">*  <?php echo $lastname_err ?></span>
                                <input type="text" name="lastname"  value="<?php echo $lastname; ?>">
                                <br><br>


                                <label>Address</label>
                                <span class="error">*  <?php echo $address_err ?></span>
                                <input type="text" name="address"  value="<?php echo $address; ?>">
                                <br><br>


                                <label>City</label>
                                <span class="error">*  <?php echo $city_err ?></span>
                                <input type="text" name="city"  value="<?php echo $city; ?>">
                                <br><br>


                                <label>Postal code</label>
                                <span class="error">*  <?php echo $postal_code_err ?></span>
                                <input type="text" name="postal_code"  value="<?php echo $postal_code; ?>">
                                <br><br>


                                <label>Username</label>
                                <span class="error">*  <?php echo $username_err ?></span>
                                <input type="text" name="username"  value="<?php echo $username; ?>">
                                <br><br>


                                <label>Password</label>
                                <span class="error">*  <?php echo $password_err ?></span>
                                <input type="password" name="password"  value="<?php echo $password; ?>">
                                <br><br>

                                <label>Picture</label>
                                <span class="error">*  <?php echo $avatar_err ?></span>
                                <br>
                                <input type="file" name="avatar" value="<?php // echo $avatar; ?>">
                                <br><br>


                                <div class="">
                                    <input type="submit" style="background-color: #1d5962; margin-bottom: 2px;" value="Submit" name="signup">

                                </div>
                                <p>Already have an account? <a href="login.php">Login here</a>.</p>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </body>
</html>
<?php


// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-19 added file and intialized.
// Aafrin Sayani (2030150) 2022-04-19 generated basic html, added css, session.
// Aafrin Sayani (2030150) 2022-04-20 woked on the logic
// Aafrin Sayani (2030150) 2022-04-20 handeled errors.
// Aafrin Sayani (2030150) 2022-04-20 prevented HTLML injection
// Aafrin Sayani (2030150) 2022-04-20 inserted data, added avatar, create password hash, image storing.
// Aafrin Sayani (2030150) 2022-04-23 Added objects and mehtods.
// Aafrin Sayani (2030150) 2022-04-23 Prevented sql injection.
// Aafrin Sayani (2030150) 2022-04-23 Finalized register page.


// Including common functions file
include_once('functions/phpfunction.php');

// Prevent page caching
noCache();

// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Sign-Up Page");

// Check if the user is logged in 
if(isset($_SESSION["id"]))
{
    //if logged in then show firstname and lastname 
    checkLogin();
     exit;
}
else
{
    // if not then show logout button.
    checkLogin();
    
}

// Define variables and initialize with empty values  to prevent from having warinings
$username= $avatar = $password = $firstname = $lastname = $address = $city = $postal_code = $province = "";
$firstname_err = $lastname_err = $address_err = $city_err = $postal_code_err = $avatar_err= "";
$username_err = $password_err = "";
$avatar = NULL;

// Processing form data when form is submitted
if (isset($_POST["signup"])) {
    // Readiing Image file data
    if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        //if all good then save binary file contents.
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
       // $customer->setAvatar($avatar);
        
    } else {
        $avatar_err = "please upload a file";
    }
    // Save form filled data by preventing form html injection
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $address = htmlspecialchars($_POST["address"]);
    $city = htmlspecialchars($_POST["city"]);
    $postal_code = htmlspecialchars($_POST["postal_code"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Validate input fields
    // Create customer object 
    $customer = new customer();

    if (empty(htmlspecialchars($_POST["firstname"]))) {
        // Setting the values into the customer object to generate error string already validated in the class.
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
// if all the fields are not empty and setted,  prepare to manipulate data into the database.
    else {
        //check if the user name  exists in the database or not

        // Prepare a select statement with username provided to check if the username already exists.
        $sql = "CALL login(:username)";
        //$sql = "SELECT * FROM customers WHERE username = :username";

        if ($PDOobject = $connection->prepare($sql)) {

            // Bind variables to the prepared statement as parameters
            $PDOobject->bindParam(":username", $p_username, PDO::PARAM_STR);

            // Set parameters
            $p_username = $username;

            // Eexecute the prepared statement
            if ($PDOobject->execute()) {
                if ($PDOobject->rowCount() == 1) {
                    $username_err = "It didnt work, Try different username!";
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



    // Check if error strings are empty before inserting into database
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
 
            // Attempt to execute the prepared statement to store user information into the database
            if ($PDOobject->execute()) {
                //Redirect to login page if the user is done entering valid data
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

//Call signup html  funciton with the errors strings recieved from the validations.
signUpHTML($customer, $username_err,$password_err,$firstname_err,$lastname_err,$address_err,$city_err,$postal_code_err,$avatar_err,$username,$avatar,$password,$firstname,$lastname,$address,$city,$postal_code,$province);
?>


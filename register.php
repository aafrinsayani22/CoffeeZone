<?php
session_start();


// Include config file
require_once "config.php";

require_once "customer.php";
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call


// Page Structure
noCache();

// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Buy Page");


?>

<?php







 // Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: login.php");
//    exit;
//}
// Define variables and initialize with empty values

$username = $password = $firstname = $lastname = $address = $city = $postal_code = "";
$firstname_err = $lastname_err = $address_err = $city_err = $postal_code_err  = "";
$username_err = $password_err  = "";
 
// Processing form data when form is submitted
if(isset($_POST["signup"])){ 
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $postal_code = $_POST["postal_code"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Validate input fields
    
    // Create customer objct
    $customer = new customer();
    //check if the user name  exists in the database or not
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = $customer->setFirstname($firstname);
    } 
    else if(empty(trim($_POST["lastname"]))){
        $lastname_err = $customer->setLastname($lastname);
    }
    else if(empty(trim($_POST["address"]))){
        $address_err = $customer->setAddress($address);
    }
    else if(empty(trim($_POST["city"]))){
        $city_err = $customer->setCity($city);
    }
    else if(empty(trim($_POST["postal_code"]))){
        $postal_code_err = $customer->setPostal_code($postal_code);
    }
    else if(empty(trim($_POST["username"]))){
        $username_err = $customer->setUsername($username);
    }  // if all the fields are not empty and setted,  prepare to manipulate data with sql
    else{
        
        // Prepare a select statement with username provided to check if the username already exists.
        $sql = "SELECT * FROM customers WHERE username = :username";
      
        if($PDOobject = $connection->prepare($sql)){
            
            // Bind variables to the prepared statement as parameters
              $PDOobject->bindParam(":username", $p_username, PDO::PARAM_STR);
              
            // Set parameters
            $p_username = $username;

            // Eexecute the prepared statement
            if($PDOobject->execute()){
                if($PDOobject->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    // Store the value into customer object of the given username.
                    $customer->setUsername(trim($username));
               
                }
            } else{
                echo "Oops! Something went wrong with the connection. Please try again later.";
            }

            // Close statement
            unset($PDOobject);
        }
    }
    
    // Validate password
    // Check if password is empty
    if(empty(trim($password))){
        $password_err = $customer->setPassword($password);  
    } 
    else{
        // Store the value of the password into the object
        $customer->setPassword(trim($password));

    }
    
    // Check if error strings are empty before inserting in database
    if(empty($username_err) && empty($password_err)&&empty($firstname_err) && empty($lastname_err) && empty($address_err)&&empty($city_err) && empty($postal_code_err)){
        
        // Prepare sql query
        $sql = "INSERT INTO customers (firstname,lastname,address,city,postal_code,username, password) VALUES (:firstname,:lastname,:address,:city,:postal_code,:username,:password)";
        // 
        //$sql = "CALL customer_insert(:firstname, :lastname, :address, :city, :postal_code, :username, :password)";
         
        if($PDOobject = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $PDOobject->bindParam(":firstname", $firstname, PDO::PARAM_STR);
            $PDOobject->bindParam(":lastname", $lastname, PDO::PARAM_STR);
            $PDOobject->bindParam(":address", $address, PDO::PARAM_STR);
            $PDOobject->bindParam(":city", $city, PDO::PARAM_STR);
            $PDOobject->bindParam(":postal_code", $postal_code, PDO::PARAM_STR);
            $PDOobject->bindParam(":username",$username , PDO::PARAM_STR);
            $PDOobject->bindParam(":password", $p_password, PDO::PARAM_STR);
            
            // Set parameters

            $p_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($PDOobject->execute()){
                //Redirect to login page
                header("location: login.php");
            } else{
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    
    <section class="section-how" id="how">
        <div class="container">
          <h2 class="heading-primary" style="margin-bottom: 2.5rem">
            Welcome Folk
          </h2>
          <h1 class="heading-secondary">Please Create New account with your personal account information.


</h1>
        </div>

        <div class="container grid grid--2-cols-reg grid--center-v">
          <!-- STEP 02 -->
          <div class="step-img-box">
            <embed src="./undraw_profile-register.svg" />
          </div>


          <div class="step-text-box">
                      <div class="form" style="
                      /*box-sizing: border-box;*/
                      font-size: large;
                      padding: 5px;
                      color: #fff;
                  ">

          <div class="Container-form" style="background-color: #39b2c4;">
          <p><span class="error" style="color: red; ">* Required field</span></p>
              <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Firstname</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>  
            
            <div class="form-group">
                <label>Lastname</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div>  
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                <span class="invalid-feedback"><?php echo $address_err; ?></span>
            </div>  
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div>  
            <div class="form-group">
                <label>Postal code</label>
                <input type="text" name="postal_code" class="form-control <?php echo (!empty($postal_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $postal_code; ?>">
                <span class="invalid-feedback"><?php echo $postal_code_err; ?></span>
            </div>  
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>  

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
   
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" name="signup">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
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
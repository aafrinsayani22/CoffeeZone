<?php
// Include config file
require_once "config.php";

require_once 'customer.php';

 
// Define variables and initialize with empty values
$firstname = $lastname = $address = $city = $postal_code  = "";
$username = $password = "";
$firstname_err = $lastname_err = $address_err = $city_err = $postal_code_err  = "";
$username_err = $password_err  = "";
 
// Processing form data when form is submitted
if(isset($_POST["signup"])){ 
 
    // Validate input fields
    
    // Create customer objct
    $customer = new customer();
    //check if the user name  exists in the database or not
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = $customer->setFirstname($_POST["firstname"]);
    } 
    else if(empty(trim($_POST["lastname"]))){
        $lastname_err = $customer->setLastname($_POST["lastname"]);
    }
    else if(empty(trim($_POST["address"]))){
        $address_err = $customer->setAddress($_POST["address"]);
    }
    else if(empty(trim($_POST["city"]))){
        $city_err = $customer->setCity($_POST["city"]);
    }
    else if(empty(trim($_POST["postal_code"]))){
        $postal_code_err = $customer->setPostal_code($_POST["postal_code"]);
    }
    else if(empty(trim($_POST["username"]))){
        $username_err = $customer->setUsername($_POST["username"]);
    }  // if all the fields are not empty and setted,  prepare to manipulate data with sql
    else{
        // Prepare a select statement with username provided to check if the username already exists.
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($PDOobject = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
              $PDOobject->bindParam(":username", $p_username, PDO::PARAM_STR);
            // Set parameters
            $p_username = $customer->getUsername();
            
            // Eexecute the prepared statement
            if($PDOobject->execute()){
                if($PDOobject->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    // Store the value into customer object of the given username.
                    $customer->setUsername(trim($_POST["username"]));
               
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
    if(empty(trim($_POST["password"]))){
        $password_err = $customer->setPassword($_POST["password"]);  
    } 
    else{
        // Store the value of the password into the object
        $customer->setPassword(trim($_POST["password"]));

    }
    
    // Validate confirm password
    // Double check the password
//    if(empty(trim($_POST["confirm_password"]))){ // Check if its empty
//        $confirm_password_err = "Please confirm password.";     
//    } else{
//        
//        if(empty($password_err) && empty($password != $confirm_password)){
//            $confirm_password_err = "Password did not match.";
//        }
//        $confirm_password = trim($_POST["confirm_password"]); 
//    }
    
    // Check if error strings are empty before inserting in database
    if(empty($username_err) && empty($password_err)&&empty($firstname_err) && empty($lastname_err) && empty($address_err)&&empty($city_err) && empty($postal_code_err)){
        
        // Prepare sql query
        $sql = "CALL customer_insert(:firstname, :lastname, :address, :city, :postal_code, :username, :password)";
         
        if($PDOobject = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $PDOobject->bindParam(":firstname", $p_firstname, PDO::PARAM_STR);
            $PDOobject->bindParam(":lastname", $p_lastname, PDO::PARAM_STR);
            $PDOobject->bindParam(":address", $p_address, PDO::PARAM_STR);
            $PDOobject->bindParam(":city", $p_city, PDO::PARAM_STR);
            $PDOobject->bindParam(":postal_code", $p_postal_code, PDO::PARAM_STR);
            $PDOobject->bindParam(":username",$p_username , PDO::PARAM_STR);
            $PDOobject->bindParam(":password", $p_password, PDO::PARAM_STR);
            
            // Set parameters
            $p_firstname = $customer->getFirstname();
            $p_lastname = $customer->getLastname();
            $p_address =  $customer->getAddress();
            $p_city = $customer->getCity();
            $p_postal_code = $customer->getPostal_code();
            $p_username = $customer->getUsername();
            $p_password = password_hash($customer->getPassword(), PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($PDOobject->execute()){
                // Redirect to login page
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
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
</body>
</html>
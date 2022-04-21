
<?php
session_start();


// Include config file
require_once "config.php";

require_once "customer.php";
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call


// Page Structure


// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Sign-Up Page");


?>

<?php


// Include config file

 
// Define variables and initialize with empty values
$username = $password = $firstname = $lastname = $address = $city = $postal_code = "";
$firstname_err = $lastname_err = $address_err = $city_err = $postal_code_err  = "";
$username_err = $password_err  = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Get hidden input value
    $id = $_SESSION["id"];
    
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
    } 
    else if(empty(trim($password))){
        $password_err = $customer->setPassword($password);  
    } else{
       
        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err)&&empty($firstname_err) && empty($lastname_err) && empty($address_err)&&empty($city_err) && empty($postal_code_err)){
            // Prepare an update statement
            $sql = "UPDATE customers SET firstname=:firstname, lastname=:lastname, address=:address, city=:city, postal_code=:postal_code, username=:username, password=:password WHERE customer_id=:customer_id";

            if($stmt = $connection->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":firstname", $p_firstname, PDO::PARAM_STR);
                $stmt->bindParam(":lastname", $p_lastname, PDO::PARAM_STR);
                $stmt->bindParam(":address", $p_address, PDO::PARAM_STR);
                $stmt->bindParam(":city", $p_city, PDO::PARAM_STR);
                $stmt->bindParam(":postal_code", $p_postal_code, PDO::PARAM_STR);
                $stmt->bindParam(":username",$p_username , PDO::PARAM_STR);
                $stmt->bindParam(":password", $p_password, PDO::PARAM_STR);
                $stmt->bindParam(":customer_id", $p_customer_id);

                // Set parameters
                
                $p_firstname = $firstname;
                $p_lastname = $lastname;
                $p_address = $address;
                $p_city = $city;
                $p_postal_code = $postal_code;
                $p_username = $username;
                $p_password = $p_password = password_hash($password, PASSWORD_DEFAULT);
                $p_customer_id = $id;


                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Records updated successfully. Redirect to landing page
                    //header("location: index.php");
                    echo "Updated successfully";
                    //exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            unset($stmt);
        }
    }
    // Close connection
    unset($pdo);
} else{
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
   
    // Check existence of id parameter before processing further
    //if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  $_SESSION["id"];
        
        // Prepare a select statement
        $sql = "SELECT * FROM customers WHERE customer_id = :id";
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
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
                    
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($connection);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Firstname</label>
                            <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                            <span class="invalid-feedback"><?php echo $firstname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Lastname</label>
                            <textarea name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"><?php echo $lastname; ?></textarea>
                            <span class="invalid-feedback"><?php echo $lastname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                            <span class="invalid-feedback"><?php echo $city_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Postal Code:</label>
                            <input type="text" name="postal_code" class="form-control <?php echo (!empty($postal_code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $postal_code; ?>">
                            <span class="invalid-feedback"><?php echo $postal_code_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                                                <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php
// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-02-17 Created NB proj
// Aafrin Sayani (2030150) 2022-02-19 Add funcs/CSS
// Aafrin Sayani (2030150) 2022-02-25 Completed index
// Aafrin Sayani (2030150) 2022-03-1 Completed Buy Pg
// Aafrin Sayani (2030150) 2022-03-04 Completed JSON
// Aafrin Sayani (2030150) 2022-03-05 More Comments
// Aafrin Sayani (2030150) 2022-03-05 Finalized Orders page.
// Include config file
require_once "config.php";

require_once "customer.php";
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call
// Include config file
require_once "config.php";
// Defining Constant variables for later use.
require_once './config.php';
define("FILE_INDEX", "./index.php");

define("FILE_UPDATE", "./account.php");
define("FILE_BUY", "./buy.php");
define("FILE_REGISTER", "./register.php");
define("FILE_MYORDERS", "./orders.php");
define("JSON_TEXT_FILE", "JSON.txt");
define("FOLDER_IMAGES", "pictures/");
define("LOGO_IMAGE", FOLDER_IMAGES . "logo5.png");
define("FOLDER_CSS", "CSS/");
define("FILE_CSS", FOLDER_CSS . "style.css");
define("PRINT_CSS", FOLDER_CSS . "print.css");

// Define variables and initialize with empty values
$username = $password = $avatar = $lastname = "";
$username_err = $password_err = $login_err = "";



function session() {
global $connection;
    if (isset($_SESSION["id"])) {
        global $connection;
        $sql = "SELECT * FROM customers WHERE customer_id = :id";
        if ($stmt = $connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);

            // Set parameters
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    /* Fetch result row as an associative array. Since the result set
                      contains only one row, we don't need to use while loop */

                    // Retrieve individual field value
                    ?>
                    <div class="avatar-right" style="float: right">
                    <?php
                    echo "<img class='avatar' src='data:image; base64," .
                    base64_encode($row["avatar"]) . "'>";

                    $firstname = $row["firstname"];
                    $lastname = $row["lastname"];

                    echo "  {$firstname} {$lastname} ";

                    
                    echo "<a class='main-nav-link nav-cta' style='float: right; margin: 5px;' href='logout.php'>Logout!</a>";
                  
                    ?>
                    </div>

                        <?php
                }
//                    } else {
//                        // URL doesn't contain valid id. Redirect to error page
//                        
//                        exit();
//                    }
                }
            }
        } else {
            echo "<a class='main-nav-link nav-cta' style='float: right; margin: 5px;' href='login.php'>Please login!</a>";
           
        }
    }

    function login_final() {
        global $connection;
        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Check if username is empty
            if (empty(htmlspecialchars($_POST["username"]))) {
                $username_err = "Please enter username.";
            } else {
                $username = htmlspecialchars($_POST["username"]);
            }

            // Check if password is empty
            if (empty(htmlspecialchars($_POST["password"]))) {
                $password_err = "Please enter your password.";
            } else {
                $password = htmlspecialchars($_POST["password"]);
            }

            // Validate credentials
            if (empty($username_err) && empty($password_err)) {
                // Prepare a select statement
                $sql = "SELECT customer_id, username, password FROM customers WHERE username = :username";

                if ($PDOobject = $connection->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $PDOobject->bindParam(":username", $param_username, PDO::PARAM_STR);

                    // Set parameters
                    $param_username = trim($_POST["username"]);

                    // Attempt to execute the prepared statement
                    if ($PDOobject->execute()) {
                        // Check if username exists, if yes then verify password
                        if ($PDOobject->rowCount() == 1) {
                            if ($row = $PDOobject->fetch()) {
                                $id = $row["customer_id"];
                                $username = $row["username"];
                                $avatar = $row["avatar"];
                                $hashed_password = $row["password"];
                                if (password_verify($password, $hashed_password)) {
                                    // Password is correct, so start a new session
                                    session_start();

                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    $_SESSION["lastname"] = $lastname;
                                    $_SESSION["avatar"] = $avatar;

                                    // Redirect user to welcome page
                                    header("location: welcome.php");
                                } else {
                                    // Password is not valid, display a generic error message
                                    $login_err = "Invalid  password.";
                                }
                            }
                        } else {
                            // Username doesn't exist, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    } else {
                        echo "Oops! Something went wrong . Please try again later.";
                    }

                    // Close statement
                    unset($PDOobject);
                }
            }

            // Close connection
            unset($connection);
        }
    }

    function login() {
        ?>
    <div class="Container-form" style="background-color: #39b2c4;">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

    <?php
    if (!empty($login_err)) {
        echo '<div class="">' . $login_err . '</div>';
    }
    ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <span class="error">*  <?php echo $username_err ?></span>
            <label>Username</label>
            <input type="text" name="username"  value="<?php echo $username; ?>">
            <br><br>

            <span class="error">*  <?php echo $password_err ?></span>
            <label>Password</label>
            <input type="password" name="password" >


            <div class="">
                <input type="submit" style="background-color: #1d5962; margin-bottom: 2px;"  value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">  Sign up now</a>.</p>
        </form>
    </div><?php
}

//Defining login page
function LoginHTML() {
    ?>
    <div class="Container-form" style="background-color: #39b2c4;">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

    <?php
    if (!empty($login_err)) {
        echo '<div class="">' . $login_err . '</div>';
    }
    ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <span class="error">*  <?php echo $username_err ?></span>
            <label>Username</label>
            <input type="text" name="username"  value="<?php echo $username; ?>">
            <br><br>

            <span class="error">*  <?php echo $password_err ?></span>
            <label>Password</label>
            <input type="password" name="password" >


            <div class="">
                <input type="submit" style="background-color: #1d5962; margin-bottom: 2px;"  value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">  Sign up now</a>.</p>
        </form>
    </div>
    <?php
}

function login_html() {
    global $connection;
    ?>


    <div class="Container-form" style="background-color: #39b2c4;">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

    <?php
    if (!empty($login_err)) {
        echo '<div class="">' . $login_err . '</div>';
    }
    ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <span class="error">*  <?php echo $username_err ?></span>
            <label>Username</label>
            <input type="text" name="username"  value="<?php echo $username; ?>">
            <br><br>

            <span class="error">*  <?php echo $password_err ?></span>
            <label>Password</label>
            <input type="password" name="password" >


            <div class="">
                <input type="submit" style="background-color: #1d5962; margin-bottom: 2px;"  value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">  Sign up now</a>.</p>
        </form>
    </div>
    <?php
}

// Defining Top page function for using it multiple times and Defining HTML only once.
function PageTop($pageTitle) {

    // Defining HTML structure.
    ?>
    <!DOCTYPE html>

    <html lang="en">

        <head>

            <meta charset="UTF-8" />
            <title><?php echo $pageTitle; ?></title>

            <link rel="stylesheet" type="text/css" href="<?php
    //for changing the style sheet path by checking the current page and command parameters.
    if (($pageTitle == "orders page") && (isset($_GET['command']) && $_GET['command'] == "print")) {
        echo PRINT_CSS;
    } else {
        echo FILE_CSS;
    }
    ?>">

        </head>

        <body>

    <?php
}

// Creating function for navigation bar for multiple use on every page.
function navigationMenu() {
    ?>
            <header class="header">
                <a href=" <?php echo FILE_INDEX ?>">
                    <img class="logo" alt="Aafrin Cafe logo" src=" <?php echo LOGO_IMAGE ?>">
                </a>

                <nav class="main-nav">
                    <ul class="main-nav-list">
                        <li><a class="main-nav-link nav-cta" href="<?php echo FILE_INDEX; ?>">Home</a></li>
                        <li><a class="main-nav-link nav-cta" href="<?php echo FILE_BUY; ?>">Buy</a></li>
                        <li>
                            <a class="main-nav-link nav-cta" href="<?php echo FILE_MYORDERS; ?>">My Orders</a>
                        </li>
                        <li><a class="main-nav-link nav-cta" href="<?php echo FILE_UPDATE; ?>">Account</a></li>
                    </ul>
                </nav>
            </header>
    <?php
}

// Creating page bottom function.
function PageBottom() {
    ?>

            <p class="bottom heading-secondary">Copyright © <?php echo date("Y"); ?>. By Aafrin Sayani (2030150) CAFÉ Inc. All rights reserved.
            </p>
        </body>

    </html>

    <?php
}

function signUp() {
    ?>

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
                            <input type="file" name="avatar" value="<?php // echo $avatar;  ?>">
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
    <?php
}

// Function to test the string and extract the data only and protect from HTML and JS injections..
//function test_input($data)
//{
//  $data = trim($data);
//  $data = stripslashes($data);
//  $data = htmlspecialchars($data);
//
//  return $data;
//}
//function noCache()
//{
//
//  header('Expires: Sat, 03 Dec 1994 16:00:00 GMT');
//  header('Cache-Control: no-cache');
//  header('Pragma: no-cache');
//  header('Content-type: text/html; charset=UTF-8');
//}
//define("DEBUG_MODE", false); #true means I am debugging (development)
#false means I put  my website in the internet (production)
//function manageError($errorNumber, $errorString, $errorFile, $errorLine)
//{
//  if (DEBUG_MODE == true) {
//
//
//    #for developers
//    echo "<br>An Error " . $errorNumber . " (" . $errorString . ") occured in the file" .
//      $errorFile . " at line " . $errorLine;
//  } else {
//    #for end users
//    echo "An Error occured";
//  }
//
//  #save the detailed error in the file
//
//  exit(); #kill PHP
////}
//function manageException($Exception)
//{
//  if (DEBUG_MODE == true) {
//
//
//    #for developers
//    echo "<br>An Error " . $Exception->getCode() . " (" . $Exception->getMessage() . ") occured in the file" .
//      $Exception->getFile() . " at line " . $Exception->getLine();
//  } else {
//    #for end users
//    echo "Exception Occured";
//  }
//
//  #save the detailed error in the file
//
//  exit(); #kill PHP
//}
//function alert($message)
//{
//  echo '<script>alert($message)</script>';
//}
//
//set_error_handler("manageError");
//set_exception_handler("manageException");
?>
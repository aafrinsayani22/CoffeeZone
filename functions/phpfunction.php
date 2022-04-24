<?php
// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-20 Added check login function.
// Aafrin Sayani (2030150) 2022-04-20 Fixed check login funtion
// Aafrin Sayani (2030150) 2022-04-20 Added login html function
// Aafrin Sayani (2030150) 2022-04-21 Added signup html funciton
// Aafrin Sayani (2030150) 2022-04-21 Added table funciton to show into the orders page.
//Defining Cnnstants and files
// Include config file
require_once "config.php";
//require_once "register.php";
require_once './classes/customer.php';
require_once './classes/product.php';
require_once './classes/order.php';
//include 'register.php';
//require_once('register.php');
define("FILE_INDEX", "./index.php");
define("FILE_UPDATE", "./account.php");
define("FILE_BUY", "./buy.php");
define("FILE_REGISTER", "./register.php");
define("FILE_MYORDERS", "./orders.php");
define("FILE_LOGIN", "./login.php");
define("FOLDER_IMAGES", "pictures/");
define("FOLDER_CHEATSHEET", "cheatsheet/");
define("CHEAT_SHEET", FOLDER_CHEATSHEET . "PHP_CHEAT_SHEET.txt");
define("LOGO_IMAGE", FOLDER_IMAGES . "logo5.png");
define("FOLDER_CSS", "CSS/");
define("FILE_CSS", FOLDER_CSS . "style.css");
define("PRINT_CSS", FOLDER_CSS . "print.css");
define("FOLDER_PICTURES", "pictures/");
define("PICTURE_COFFEE1", FOLDER_PICTURES . "FrenchPress.jpeg");
define("PICTURE_COFFEE2", FOLDER_PICTURES . "MiniGrinder.jpeg");
define("PICTURE_COFFEE3", FOLDER_PICTURES . "FrenchPress.jpeg");
define("PICTURE_COFFEE4", FOLDER_PICTURES . "VacuumPot.jpeg");
define("PICTURE_COFFEE5", FOLDER_PICTURES . "Coffee_Grinder.jpeg");

function tableOrders() {
    ?>
    <section class="section-how" id="how">

        <form name='frmSearch' action='' method='post'>
            <div class="search-box" style='text-align:right;margin:20px 0px;'><input type='text' name='date' value="" id='keyword' maxlength='25'>  <input class="search-btn"type="button" style="background-color: #1d5962; margin-top: 5px; color: #fff;" value="Search" name="signup" ></div> 
            <table class='tbl-qa' id="Table1" >
                <thead>
                    <tr>
                        <th class='table-header' width='20%'>Date</th>
                        <th class='table-header' width='40%'>Product Code</th>
                        <th class='table-header' width='20%'>Firstname</th>
                        <th class='table-header' width='20%'>Lastname</th>
                        <th class='table-header' width='20%'>City</th>
                        <th class='table-header' width='40%'>Comments</th>
                        <th class='table-header' width='20%'>Price</th>
                        <th class='table-header' width='20%'>Qty</th>
                        <th class='table-header' width='40%'>Subtotal</th>
                        <th class='table-header' width='20%'>Taxes</th>
                        <th class='table-header' width='20%'>Total</th>
                        <th class='table-header' width='20%'>Delete</th>
                    </tr>
                </thead>
                <tbody id='table-body'>

                </tbody>
            </table>

        </form>
    </section>
    <?php
}

// Creating function to print the HTML table in orders page 
function table($row) {
    ?>
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
    </tr> <?php
}

//Creating function to generate buy page HTML.
function buyForm($quantity, $comment, $prod_id, $quantity_err, $comment_err) {
    ?>
    <div class="Container-form" style="background-color: #39b2c4;">
        <h2>Buy</h2>
        <p>Choose Items.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <span class="error">*  <?php echo $quantity_err ?></span>
            <label>Quantity</label>
            <input type="text" name="quantity"  value="<?php //echo $quantity;        ?>">
            <br><br>
            <span class="error"><?php echo $comment_err ?></span>
            <label>Comment</label>
            <input type="text" name="comment" value="<?php // echo $comment;        ?> ">
            <div class="">
                <input type="submit" style="background-color: #1d5962; margin-bottom: 2px;"  value="Buy">
            </div>

        </form>
    </div>
    <?php
}

// Function to shuffle the array of images for advartising purpose in index page.
function imageShuffle() {
    $myArray = array(PICTURE_COFFEE1, PICTURE_COFFEE2, PICTURE_COFFEE5, PICTURE_COFFEE4);
    // Defining an arrays of Advertising images.
    // Shufflling images to show random images when we acess the first index of the array.
    shuffle($myArray);
    ?>
    <section>
        <a class="main-nav-link nav-cta" href=" <?php echo CHEAT_SHEET ?>" download='CheatSheet-Aafrin'>
            Cheat sheet
        </a>
        <div class="container grid  grid--center-v grid--2-cols">
            <div>
                <section class="section-head">
                    <div class="head">
                        <div>
                            <h2 class="heading-primary">
                                About us
                            </h2>
                            <p class="head-description">
                                Our mission since we started has stayed simple: introduce our customers to the estates we directly buy our great tasting coffee from, roast the beans with care, and make high quality coffee more accessible through our cafes and our website. The coffee we roast is the coffee we like to drink, and we hope you like it too.
                            </p>
                            <p class="heading-secondary">A culture of constant learning is the key to always pushing coffee forward.</p>
                            <p class="head-description">
                                We are consistently researching, testing and implementing best practices throughout our business to raise the bar. Making refractometers essential for our cafe brewing, holding advanced sensory learnings for junior roasters, and experimenting with processing at the farm level are just some of the ways that our highly skilled team is constantly evolving the way Indian coffee is treated, experienced or communicated about.
                            </p>
                        </div>

                    </div>

                </section>
            </div>

            <div>
                <a target="_blank" href="https://eightouncecoffee.ca/">
                    <img class="<?php
                    // if the index of the array is 0 then apply different css to enlarge the image
                    if ($myArray[0] == PICTURE_COFFEE1) {

                        echo "bigImage";
                    } else {

                        echo "smallImage";
                    }
                    ?>" src="<?php echo $myArray[0]; ?>" alt="Advertisement"> </a>
            </div>

    </section>
    <?php
}

function checkLogin() {
    global $connection;
    if (isset($_SESSION["id"])) {
        global $connection;
        // Call procedure to get all details of a customer.
        $sql = "CALL customer_select(:id)";
        //$sql = "SELECT * FROM customers WHERE customer_id = :id";
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

                    // Retrieve individual field values ot display at the top.
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
//                   
            }
        }
    } else {
        echo "<a class='main-nav-link nav-cta' style='float: right; margin: 5px;' href='login.php'>Please login!</a>";
    }
}

// Function ot generate login html
function loginHTML($username, $password, $avatar, $lastname, $username_err, $password_err, $login_err) {
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

// generate signuP html code
function signUpHTML($username_err, $password_err, $firstname_err, $lastname_err, $address_err, $city_err, $postal_code_err, $avatar_err, $username, $avatar, $password, $firstname, $lastname, $address, $city, $postal_code, $province) {
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
                            <input type="file" name="avatar" value="<?php // echo $avatar;   ?>">
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

// To prevent the page from page caching
function noCache() {

    header('Expires: Sat, 03 Dec 1994 16:00:00 GMT');
    header('Cache-Control: no-cache', 'no-store');
    header('Pragma: no-cache');
    header('Content-type: text/html; charset=UTF-8');
}

function account($username_err, $password_err, $username, $avatar, $password, $firstname, $lastname, $province, $address, $city, $postal_code, $firstname_err, $lastname_err, $address_err, $city_err, $postal_code_err, $avatar_err) {
    ?>
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
                            <input type="file" name="avatar" value="<?php // echo $avatar;    ?>">
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
    <?php
}
//
//function https() {
//    if ($_SERVER["HTTPS"] != "on") {
//        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//        exit();
//    }
//}
//
//https();

//
//define("DEBUG_MODE", false); #true means I am debugging (development)
//#false means I put  my website in the internet (production)
//
//function manageError($errorNumber, $errorString, $errorFile, $errorLine) {
//    if (DEBUG_MODE == true) {
////
////
////    #for developers
//        echo "<br>An Error " . $errorNumber . " (" . $errorString . ") occured in the file" .
//        $errorFile . " at line " . $errorLine;
//    } else {
////    #for end users
//        echo "An Error occured";
//    }
////
////  #
////save the detailed error in the file
//    exit(); #kill PHP
//}
//
//function manageException($Exception) {
//    if (DEBUG_MODE == true) {
//
//        #for developers
//        echo "<br>An Error " . $Exception->getCode() . " (" . $Exception->getMessage() . ") occured in the file" .
//        $Exception->getFile() . " at line " . $Exception->getLine();
//    } else {
////    #for end users
////    echo "Exception Occured";
//    }
////
////  #save the detailed error in the file
//    $log_file = "./my-errors.txt";
//    exit(); #kill PHP
//}
//
////
//set_error_handler("manageError");
//set_exception_handler("manageException");
?>
<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-19 Created file.
// Aafrin Sayani (2030150) 2022-04-19 Added basic html,css, & Added session.
// Aafrin Sayani (2030150) 2022-04-19 worked on session.
// Aafrin Sayani (2030150) 2022-04-19 worked on session with logout.
// Aafrin Sayani (2030150) 2022-04-19 worked on html injection and validations.
// Aafrin Sayani (2030150) 2022-04-19 finanlized work by testing.
// Aafrin Sayani (2030150) 2022-04-19 Added css for the new links and cheatsheet.
// Aafrin Sayani (2030150) 2022-04-22 added check login session.
// Aafrin Sayani (2030150) 2022-04-22 prevented from sql/HTML injection
// Aafrin Sayani (2030150) 2022-04-23 Completed by fixing issues.

// Include config file
require_once "config.php";

require_once './classes/customer.php';
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $avatar = $lastname = "";
$username_err = $password_err = $login_err = "";
// Page Structure
//noCache();
// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Buy Page");
?>

<?php
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}



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
        $sql = "CALL login(:username)";
        //$sql = "SELECT customer_id, username, password FROM customers WHERE username = :username";

        if ($PDOobject = $connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $PDOobject->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = htmlspecialchars($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($PDOobject->execute()) {
                // Check if username exists, if yes then verify password
                if ($PDOobject->rowCount() == 1) {
                    if ($row = $PDOobject->fetch()) {
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            $id = $row["customer_id"];
                            $username = $row["username"];
                            $avatar = $row["avatar"];
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["lastname"] = $lastname;
                            $_SESSION["avatar"] = $avatar;

                            // Redirect user to welcome page
                            header("location: index.php");
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

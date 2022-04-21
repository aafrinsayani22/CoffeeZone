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


// Defining Constant variables for later use.
define("FILE_INDEX", "./index.php");

define("FILE_BUYING", "./buying.php");
define("FILE_MYORDERS", "./myOrders.php");
define("JSON_TEXT_FILE", "JSON.txt");
define("FOLDER_IMAGES", "pictures/");
define("LOGO_IMAGE", FOLDER_IMAGES . "logo5.png");
define("FOLDER_CSS", "CSS/");
define("FILE_CSS", FOLDER_CSS . "style.css");
define("PRINT_CSS", FOLDER_CSS . "print.css");

//Defining login page
function Login()
{
 ?>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
        <label for="username">Username :</label>
        <input type="text" name="username" id="username">
        <label for="password">Password :</label>
        <input type="text" name="password" id="password">
        <br><br>
        <input type="submit" name="login" value="Login">
    </form>
<?php
}


// Defining Top page function for using it multiple times and Defining HTML only once.
function PageTop($pageTitle)
{

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
function navigationMenu()
{
  ?>
    <header class="header">
      <a href=" <?php echo FILE_INDEX ?>">
        <img class="logo" alt="Aafrin Cafe logo" src=" <?php echo LOGO_IMAGE ?>">
      </a>

      <nav class="main-nav">
        <ul class="main-nav-list">
          <li><a class="main-nav-link nav-cta" href="<?php echo FILE_INDEX; ?>">Home</a></li>
          <li><a class="main-nav-link nav-cta" href="<?php echo FILE_BUYING; ?>">Buy</a></li>
          <li>
            <a class="main-nav-link nav-cta" href="<?php echo FILE_MYORDERS; ?>">My Orders</a>
          </li>
          <li><a class="main-nav-link nav-cta" href="<?php echo FILE_BUYING; ?>">Account</a></li>
        </ul>
      </nav>
    </header>
  <?php
}


// Creating page bottom function.
function PageBottom()
{
  ?>

    <p class="bottom heading-secondary">Copyright © <?php echo date("Y"); ?>. By Aafrin Sayani (2030150) CAFÉ Inc. All rights reserved.
    </p>
  </body>

  </html>

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


define("DEBUG_MODE", false); #true means I am debugging (development)
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
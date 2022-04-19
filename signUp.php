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


// Including common functionce file
include_once('functions/phpfunction.php');

// Defining constants

define("ORDERS_PAGE", "./orders.php");
define("MAX_PROD", 12);
define("MAX_FIRSTNAME", 20);
define("MAX_LASTNAME", 20);
define("MAX_CITY", 8);
define("MIN_PRICE", 0);
define("MAX_PRICE", 10000);
define("TAX", 13.45 / 100);


// Page Structure
noCache();

// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Buy Page");


?>

<?php

// define variables and set to empty values
$prodErr = $firstNameErr = $lastNameErr = $cityErr = $priceErr = "";
$prodCode = $firstName = $lastName = $city = $comment = "";
$price = 0;
$validInput = false;
$quantity = 1;
$subTotal = 0;
$taxTotal = 0;
$grandTotal = 0;
$ordersInfo = array();
$errors = 0;



if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["prodCode"])) {
      $prodErr = "Product Code is required";
  }
  else {
      $prodCode = test_input($_POST["prodCode"]);
      // check if name only contains letters and whitespace
      if ((strlen($prodCode) > 12) || ($prodCode[0] == "p") || ($prodCode[0] == "P")) {
      $prodErr = "Must start with p/P and contains Only 12 characters long.";
      // $errors +=1;
    } else {
      $validInput = true;
    }
  }

  if (empty($_POST["firstName"])) {
    $firstNameErr = "First Name is required";
    $errors = $errors + 1;
  }
  else {
    $firstName = test_input($_POST["firstName"]);
    // check if name only contains letters and whitespace
    if (strlen($firstName) > 20) {
      $firstNameErr = "Only 20 Characrers allowed.";
      $errors = $errors + 1;
    }
    else {
      $validInput = true;
    }
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "Last Name is required";
    $errors = $errors + 1;
  } else {
    $lastName = test_input($_POST["lastName"]);
    // check if name only contains letters and whitespace
    if (strlen($lastName) > 20) {
      $lastNameErr = "Only 20 Characrers allowed.";
      $errors = $errors + 1;
    }
    else {
      $validInput = true;
    }
  }

  if (empty($_POST["city"])) {
    $cityErr = "City is required";
    $errors = $errors + 1;
  } else {
    $city = test_input($_POST["city"]);
    // check if e-mail address is well-formed
    if (strlen($city) > 8) {
      $cityErr = "Only 8 Characrers allowed.";
      $errors = $errors + 1;
    }
    else {
      $validInput = true;
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
    $validInput = true;
  }


  if (empty($_POST["price"])) {
    $priceErr = "Price is required";
    $errors = $errors + 1;
  } else {
    $price = test_input($_POST["price"]);
    // check if e-mail address is well-formed
    if (strlen($price) < 0)  {
      $priceErr = "Price must not be Negative";
      $errors = $errors + 1;
    }
    elseif ($price > 10000) {
      $priceErr = "Price cannot be higher than 10,000$";
    }
    else {
      $validInput = true;
    }
  }


  if (isset($_POST["quantity"])) { //to check if the form was submitted
    $quantity = $_POST["quantity"];
  }

}



if($errors == 0)
{

    // Calculating totals
  $subTotal = $price * $quantity;
  $subTotal =  number_format((float)$subTotal, 2, '.', '');
  $taxTotal = number_format((float)($subTotal * 0.1345), 2, '.', '');
  $grandTotal = $subTotal + $taxTotal;
  $grandTotal =  number_format((float)$grandTotal, 2, '.', '');
  // $grandTotal = ROUND($grandTotal,2);

  // Storing all the data into the array
  $ordersInfo = array($prodCode, $firstName, $lastName, $city, $comment, $price, $quantity, $subTotal, $taxTotal, $grandTotal);


  $encode_data = json_encode($ordersInfo);

  // $decode_data = json_decode($encode_data);

  $myfile = fopen(JSON_TEXT_FILE, "a") or die("Unable to open file!");

  fwrite($myfile, $encode_data  . "\n");

  fclose($myfile);


}


?>

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
              <form method="post" action="/2030150/buying.php" onsubmit="<?php echo 'return alert()' ?>">
                  <span class="error">*  <?php echo $firstNameErr ?></span>
                  First Name: <input type="text" name="firstName" value=""placeholder="First Name">
                  <br><br>

                  <span class="error">*  <?php echo $lastNameErr ?></span>
                  Last Name: <input type="text" name="lastName" value="" placeholder="Last Name">
                  <br><br>

                  <span class="error">*  <?php echo $cityErr ?></span>
                  Address: <input type="text" name="city" value=""placeholder="Address">
                  <br><br>

                  <span class="error">*  <?php echo $cityErr ?></span>
                  City: <input type="text" name="city" value=""placeholder="City">
                  <br><br>

                  <span class="error">*  <?php echo $cityErr ?></span>
                  Postal code: <input type="text" name="city" value=""placeholder="City">
                  <br><br>

                  <span class="error">*  <?php echo $cityErr ?></span>
                  Username: <input type="text" name="city" value=""placeholder="City">
                  <br><br>

                  <span class="error">*  <?php echo $cityErr ?></span>
                  Password: <input type="password" name="city" value=""placeholder="City">
                  <br><br>



                  <input style="background-color: #1d5962; margin-bottom: 2px; " type="submit" name="Register" value="Register">
              </form>
              </div>
          </div>
          </div>


        </div>
      </section>

<!-- <div class="form" style="
            /*box-sizing: border-box;*/
            font-size: large;
            padding: 5px;
            color: #fff;
        ">
<h2 style="color: black">Try Our Freshest Coffee Beans Today!</h2>
<div class="Container-form" style="background-color: #39b2c4;">
<p><span class="error" style="color: red; ">* Required field</span></p>
    <form method="post" action="/2030150/buying.php" onsubmit="<?php echo 'return alert()' ?>">

        Product Code: <input type="text" name="prodCode" value=""placeholder="Product Code">
        <span class="error">* <?php echo $prodErr ?></span>
        <br><br>

        First Name: <input type="text" name="firstName" value=""placeholder="First Name">
        <span class="error">*  <?php echo $firstNameErr ?></span>
        <br><br>

        Last Name: <input type="text" name="lastName" value="" placeholder="Last Name">
        <span class="error">*  <?php echo $lastNameErr ?></span>
        <br><br>

        City: <input type="text" name="city" value=""placeholder="City">
        <span class="error">*  <?php echo $cityErr ?></span>
        <br><br>

        Price: <input type="text" name="price" value="" placeholder="Price (0 - 10000)">
        <span class="error">*  <?php echo $priceErr ?></span>
        <br><br>

        Comment: <textarea name="comment" rows="5" cols="40" minlength="0" maxlength="200" placeholder="Please provide extra details like packaging,label etc"></textarea>
        <br><br>

        Quantity: <input type="number" name="quantity" min="1" max="99" value="1">

        <br><br>

        <input style="background-color: #1d5962; margin-bottom: 2px; " type="submit" name="submit" value="Submit">
    </form>
    </div>
</div> -->


<!-- ///////////////////////// -->
















<?php


PageBottom();
?>
<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-18 Created NB proj
// Aafrin Sayani (2030150) 2022-04-19 Added cheatsheet
// Aafrin Sayani (2030150) 2022-04-19 Added navbar links as mentioned in the description
// Aafrin Sayani (2030150) 2022-04-19 Added css for thenew links and cheatsheet.
// Aafrin Sayani (2030150) 2022-04-19 Added navbar links as mentioned in the description
// Aafrin Sayani (2030150) 2022-04-19 Added css for the new links and cheatsheet.
// Aafrin Sayani (2030150) 2022-02-22 added check login session.
// Aafrin Sayani (2030150) 2022-03-23 Completed by fixing issues.


session_start();
require_once './classes/customer.php';
require_once './config.php';






// Including the common function file to index page
include_once('functions/phpfunction.php');



$customer = new customer();

// Page Structure
//noCache();
//
// Including top page
pageTop("Home page");

// Including navigation menu
navigationMenu();



checkLogin();

// Sections for Home page text and advertising images.
imageShuffle();
?>


<?php
// Including bottom page.
pageBottom();
?>
<?php
//Start the session to read the session id if its set or not
session_start();
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
// 
// Including the common function file to index page
include_once('functions/phpfunction.php');

$customer = new customer();

// Page Structure
noCache();

// Including top page
pageTop("Home");

// Including navigation menu
navigationMenu();

//Check if the user logged in or not and view the page accordingly;
checkLogin();

// Sections for shuffle the  advertising images.
imageShuffle();

// Including bottom page.
pageBottom();
?>
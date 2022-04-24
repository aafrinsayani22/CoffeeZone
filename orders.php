<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-22 added file and intialized.
// Aafrin Sayani (2030150) 2022-04-22 generated basic html, added css, session.
// Aafrin Sayani (2030150) 2022-04-22 Added ajax.
// Aafrin Sayani (2030150) 2022-04-23 wrote logic to get the data
// Aafrin Sayani (2030150) 2022-04-23 fixed bugs
// Aafrin Sayani (2030150) 2022-04-23 Added objects and mehtods.
// Aafrin Sayani (2030150) 2022-04-23 Finalized Buy page.

session_start();

// Include config file
require_once "config.php";

require_once './classes/customer.php';
// Including common functionce file
include_once('functions/phpfunction.php');
// Navigation Bar function call
// Page Structure
noCache();
// Navigation Bar function call
navigationMenu();

// Top Page function call
PageTop("Orders Page");
if (!isset($_SESSION["id"])) {
    checkLogin();
    exit;
} else {
    checkLogin();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Product Search</title>
        <style>
            .tbl-qa{
                width: 100%;
                font-size:0.9em;
                background-color: #f5f5f5;
            }
            .tbl-qa th.table-header {
                padding: 5px;
                text-align: left;
                padding:10px;
            }
            .tbl-qa .table-row td {
                padding:10px;
                background-color: #FDFDFD;
                vertical-align:top;
            }

            body{
                font-family: Arail, sans-serif;
            }
            /* Formatting search box */
            .search-box{
                width: 300px;
                position: relative;
                display: inline-block;
                font-size: 14px;
            }
            .search-box input[type="text"]{
                height: 32px;
                padding: 5px 10px;
                border: 1px solid #CCCCCC;
                font-size: 14px;
            }

            .search-box input[type="text"], .result{
                width: 100%;
                box-sizing: border-box;
            }

        </style>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>

            $(document).ready(function () {
                $('.search-box input[type="button"]').on("click", function () {
                    /* Get input value  */
                    var inputVal = $('.search-box input[type="text"]').val();
                    var resultDropdown = $('#Table1').children('tbody');
                    if (inputVal.length) {
                        $.get("backend-search.php", {term: inputVal}).done(function (data) {
                            // Display the returned data in browser
                            resultDropdown.html(data);
                        });
                    } else {
                        resultDropdown.empty();
                    }
                });

            });
        </script>
    </head>
    <body>
        <section class="section-how" id="how">

            <form name='frmSearch' action='' method='post'>
                <div class="search-box" style='text-align:right;margin:20px 0px;'><input type='text' name='search[keyword]' value="" id='keyword' maxlength='25'>  <input class="search-btn"type="button" style="background-color: #1d5962; margin-top: 5px; color: #fff;" value="Search" name="signup" ></div> 
                <table class='tbl-qa' id="Table1">
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
    </body>
</html>



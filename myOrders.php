<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-02-17 Created NB proj
// Aafrin Sayani (2030150) 2022-02-19 Add funcs/CSS
// Aafrin Sayani (2030150) 2022-02-25 Completed index
// Aafrin Sayani (2030150) 2022-03-1 Completed Buy Pg
// Aafrin Sayani (2030150) 2022-03-04 Completed JSON
// Aafrin Sayani (2030150) 2022-03-05 Finalized Orders page.


//constants
// define constants here
define("FOLDER_PHP", "functions/");
define("FILE_PHP_COMMON", FOLDER_PHP . "phpfunction.php");
define("ORDER_FILE", "JSON.txt");
define("PHP_CHEAT_SHEET", "./PHP_CHEAT_SHEET.txt");

// Including commonFunctions.php file
include_once(FILE_PHP_COMMON);

noCache();

// Top page
PageTop("orders page");

// Navigation
navigationMenu();

?>

<a href="<?php echo PHP_CHEAT_SHEET ?>" download='CheatSheet-Aafrin'>
    Cheat sheet
</a>


<?php
// If JSON string file doesn't  exists then exit.
if (!file_exists("JSON.txt")) {
    echo "The file from above cannot be found!";
    exit;
}

// Open JSON String file
$fileOpen = fopen("JSON.txt", "r");

// If file doenst open then message
if (!$fileOpen) {
    echo "Somehow the file cannot be opened! :)";
    exit;
}


// Else if everything goes well
echo "<table id='customers' class='center'>";

// Initialize counter to count rows.
$counter = 0;

while (!feof($fileOpen)) {
    $get_line = fgets($fileOpen);


    if ($get_line != "") {
        $json_data = json_decode($get_line);
        if ($json_data != "") {



            // Print index number of lines
            echo "<tr><th>$counter</th>";

            // until the end of file read the column data.
            for ($i = 0; $i < 10; $i++) {

                // if the line number is 1 then make it table header.
                if ($counter == 0) {
                    echo "<th>$json_data[$i]</th>";
                }
                // else make it row data's.
                // Check if the data is numeric and not the quantity column to print the dollar sign.
                else if (is_numeric($json_data[$i]) && $i != 6) {

                    // if it satisfy the above test then check if the method of action have any command parameters to set the color style.
                    if (($i == 7) && (isset($_GET['command']) && $_GET['command'] == "color")) {

                        // check the range  of subtotal for specific color.
                        if ($json_data[$i] < 100) {
                            //green
                            echo "<td class='red'>$json_data[$i]$</td>";
                        } else if (($json_data[$i] >= 100)  || ($json_data <= 999)) {
                            //orange
                            echo "<td class='orange'>$json_data[$i]$</td>";
                        } else if (($i == 7) || ($json_data[$i] >= 1000)) {
                            //green
                            echo "<td class='green'>$json_data[$i]$</td>";
                        }
                    } else {
                        echo "<td>$json_data[$i]$</td>";
                    }
                } else {
                    echo "<td>$json_data[$i]</td>";
                }
            }
        }
        $counter++;
    }
}


echo "</table>";
// file close.
fclose($fileOpen);
?>

<?php
//Bottom page.
PageBottom();
?>

<?php



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
PageTop("Buy Page");


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Employees Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM customers";
                    if($result = $connection->query($sql)){
                        if($result->rowCount() > 0){
                            
                            echo '<label for="cars">Choose a car:</label>';
                                echo '<select name="product" id="cars">';
                                    
                                while($row = $result->fetch()){
                                    
                                       echo "<option value='" . $row['city'] . "'>" . $row['city'] . "</option>";
                                       
                                        
                                }
                                echo "</select>";                            
                            
                            // Free result set
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    unset($connection);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
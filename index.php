<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-02-17 Created NB proj
// Aafrin Sayani (2030150) 2022-02-19 Add funcs/CSS
// Aafrin Sayani (2030150) 2022-02-25 Completed index
// Aafrin Sayani (2030150) 2022-03-01 Completed Buy Pg
// Aafrin Sayani (2030150) 2022-03-04 Completed JSON
// Aafrin Sayani (2030150) 2022-03-05 More Comments
// Aafrin Sayani (2030150) 2022-03-05 Finalized Orders page.



// Including the common function file to index page
include_once('functions/phpfunction.php');

// Defining all the constant variables.
define("FOLDER_PICTURES", "pictures/");
define("PICTURE_COFFEE1", FOLDER_PICTURES . "FrenchPress.jpeg");
define("PICTURE_COFFEE2", FOLDER_PICTURES . "MiniGrinder.jpeg");
// define("PICTURE_COFFEE3", FOLDER_PICTURES . "FrenchPress.jpeg");
define("PICTURE_COFFEE4", FOLDER_PICTURES . "VacuumPot.jpeg");
define("PICTURE_COFFEE5", FOLDER_PICTURES . "Coffee_Grinder.jpeg");

// Page Structure

noCache();

// Including top page
pageTop("Home page");

// Including navigation menu
navigationMenu();




// Defining an arrays of Advertising images.
$myArray = array(PICTURE_COFFEE1, PICTURE_COFFEE2, PICTURE_COFFEE5, PICTURE_COFFEE4);

// Shufflling images to show random images when we acess the first index of the array.
shuffle($myArray);

// Sections for Home page text and advertising images.
?>


<section>
    


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
        <img class="<?php if ($myArray[0] == PICTURE_COFFEE1) {

                      echo "bigImage";
                    } else {

                      echo "smallImage";
                    }

                    ?>" src="<?php echo $myArray[0]; ?>" alt="Advertisement"> </a>
    </div>

</section>






<?php

// Including bottom page.
pageBottom();
?>
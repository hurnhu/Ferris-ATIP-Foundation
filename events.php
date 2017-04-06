<?php
//start all important sessions
session_start();

//make sure all functions are included, if they are not found error out
require_once "functions.php";

//this is the page type
//this is used in to get the article type
//also used in generic login to see
$t = 3;

//make sure login is included, if it is not error
require_once "templates/genericLogin.php";

$arinfo = getArticlesOfType($t);

//make sure header is included, if it is not error
require_once "templates/header.php";
?>

<div class="body-style">
    <p>
        <?php
        //make sure page controller is included, if it is not error
        require_once "templates/pgController.php";
        ?>
    </p>

    <?php
    //make sure footer is included, if it is not error
    require_once "templates/footer.php";
    ?>



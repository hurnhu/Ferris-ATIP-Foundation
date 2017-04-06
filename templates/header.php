<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Foundation | Welcome</title>
    <!--  <link rel="stylesheet" href="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/foundation.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="slick/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="slick/slick/slick-theme.css"/>
    <link href="css/footer.css" rel="stylesheet">
    <link rel="stylesheet" href="css/override.css">
              <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="slick/slick/slick.min.js"></script>
    <title>AITP</title>
</head>
<body>
<header id="header" class="header">
</header>

<div class="top-bar">
    <div id="responsive-menu">
        <div class="row medium-6 small-6">
            <div class="top-bar-title">
        <span class="stacked">
            <img src="media/aitp.png" class="respondImg">
        </span>
            </div>
        </div>
        <div class="row medium-6 small-6">
            <div class="top-bar">
                <ul class="dropdown menu" data-dropdown-menu>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="news.php">News</a></li>
                    <li><a href="calendar.php">Calendar</a></li>
                    <li><a href="forms.php">Forms</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <?php if ($_SESSION['usrInfo'][0] == true) { ?>
                        <li>
                            <a href="#">Admin</a>
                            <ul class="menu vertical">
                                <li><a href="pages.php">Pages</a></li>
                                <li><a href="users.php">users</a></li>
                            </ul>
                        </li>
                        <?php
                    } ?>

                    <li

                    <!--if user is logged in show logout else show login-->
                    <a href="#"
                       class="dropdown-Button"><?php ($_SESSION['usrInfo'][0] == true) ? print "Logout" : print "Log-in" ?></a>
                    <ul>
                        <il>
                            <a href="#">

                                <!--form that contains all of the info for the user to login-->
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <!--if user is logged in show logout button, else display login form-->
                                    <?php ($_SESSION['usrInfo'][0] == true) ? print "<button class=\"button\" type=\"submit\" name=\"submit\" value=\"logout\">Logout</button> " : print "
            <input type=\"text\" name=\"username\" placeholder=\"username\"></br>
            <input type=\"password\" name=\"password\" placeholder=\"password\"></br>
            <button class=\"button\" type=\"submit\" name=\"submit\" value=\"login\">Login</button>"
                                    ?>
                                </form>
                            </a>
                        </il>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>



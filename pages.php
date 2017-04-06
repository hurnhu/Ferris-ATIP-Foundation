<?php
//start the session
session_start();

//make sure all function are there, if not make error
require_once "functions.php";


//check to see if the user is logged in
if ($_SESSION['usrInfo'][0] == true) {

    //if they are get all the pages
    $info = getArticle();

    //get the max page id if they decide to make a new page
    $max = getMaxPageID()[2]->pgMAX;

    //check to see if server post and logout was pushed
    if ($_REQUEST['submit'] == 'logout' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        //unset all user unfo
        unset($_SESSION['usrInfo']);
    } else if ($_REQUEST['submit'] == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        //check to see if server post and login was pushed

        //get all the users info
        $_SESSION['usrInfo'] = login($_REQUEST['username'], $_REQUEST['password']);
    } else if ($_REQUEST['newPost'] == 'new' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        //check to see if server post and new was pushed

        //make a new article with a id 1 more than the max found
        newArticle($max + 1, $_REQUEST['nptype'], $_REQUEST['ntitle'], $_REQUEST['nauthor'], $_REQUEST['nbody'], $_REQUEST['nperms'], $_REQUEST['nstatue']);
    }

    //check to see if server post and if update or toggle was found to be pushed
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && (strpos($_REQUEST['submit'], 'update') !== false || strpos($_REQUEST['submit'], 'toggle') !== false)) {
        //loop through to find out which one was pushed
        foreach ($info[2] as $item) {

            //store the current element id
            $currPos = $item->pgID;

            //once it finds the correct id it will update the corresponding page
            if ($_REQUEST['submit'] == ('update' . $currPos)) {

                //update the page
                updateArticles($currPos, $_REQUEST['auth' . $currPos], $_REQUEST['title' . $currPos], $_REQUEST['body' . $currPos]);

                //get all articles to show updates
                $info = getArticle();
            } else if ($_REQUEST['submit'] == ('toggle' . $currPos)) {
                //once it finds the correct id it will toggle the status on the corresponding page

                //toggle the page status
                toggleArticleStatus($currPos);

                //get all articles to show updates
                $info = getArticle();
            }
        }
    }
}

//require the header, if not found error
require_once "templates/header.php";
?>

<div class="admin body-style">
<p>
    <?php
    //check to see if the user is logged in
    if ($_SESSION['usrInfo'][0] == true) {
        ?>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <?php
            //loop through all of the pages
            foreach ($info[2] as $item) {
                $pos = $item->pgID;

                //check to make sure the user has correct permissions to veiw and edit the page
                if ($_SESSION['usrInfo'][2]->perms <= $item->permsNeeded) { ?>
                    <p class="seperator">
                        <?php
                        //print out what type of page this is and its status
                        if ($item->pgType == 1) {
                            print "Home";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else if ($item->pgType == 2) {
                            print "About Us";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else if ($item->pgType == 3) {
                            print "Events";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else if ($item->pgType == 4) {
                            print "News";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else if ($item->pgType == 5) {
                            print "Calendar";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else if ($item->pgType == 6) {
                            print "Forms";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else if ($item->pgType == 7) {
                            print "Contact Us";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        } else {
                            print "Not Defined";
                            (!$item->active) ? print "<br/> STATUS: <span class='warning'>DISABLED</span> " : print "<br/> STATUS: <span class='allGood'>ENABLED</span> ";
                        }

                        //print out all of the parts of the current page
                        ?>
                        title:
                        <textarea
                            name="<?php print 'title' . $pos ?>"><?php print $item->title; ?></textarea>
                        author:
                        <textarea
                            name="<?php print 'auth' . $pos ?>"><?php print $item->author; ?></textarea>
                        body:
                        <textarea
                            name="<?php print 'body' . $pos ?>"><?php print $item->body; ?></textarea>
                        <button class="button" type="submit" name="submit" value="<?php print "update" . $pos ?>">update</button>
                        <button class="button" type="submit" name="submit" value="<?php print "toggle" . $pos ?>">Toggle Post Status
                        </button>
                    </p>
                    <hr/>
                <?php }
            }
            ?>

        </form>

        <!--new form gives the user the ability to make a new page.
        this also sets some required fields-->
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

            Title:
            <textarea name="ntitle"></textarea>
            Author:
            <textarea name="nauthor"></textarea>
            Body:
            <textarea name="nbody"></textarea>
            Page:
            <select name="nptype" required>
                <option value="1">Home</option>
                <option value="2">About Us</option>
                <option value="3">Events</option>
                <option value="4">News</option>
                <option value="5">Calendar</option>
                <option value="6">Forms</option>
                <option value="7">Contact Us</option>
            </select>
            </br>
            Permissions Required to edit:
            <select name="nperms" required>
                <option value="1">Admin</option>
                <option value="2">Editor</option>
            </select>
            </br>
            Status:
            <select name="nstatue" required>
                <option value="1">Enabled</option>
                <option value="2">Disabled</option>
            </select>
            </br>
            <button class="button" type="submit" name="newPost" value="new">New Post</button>
        </form>
</p>
        <?php

    } else {
//if the user is not logged in display error
        print "<p>ACCESS DENIED!</p>";

    }
    //insert the footer, error if not found
    require_once "templates/footer.php";
    ?>



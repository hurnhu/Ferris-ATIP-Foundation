<?php
//start the session
session_start();
//make sure to include al of the functions, if it is not found throw error
require_once "functions.php";
//check to see if the user is logged in
if ($_SESSION['usrInfo'][0] == true) {

    //get the max user id
    $max = getMaxUserID();

    //get the all users info
    //if curr user logged in get all of the users to be displayed
    //if curr user is not an admin, get only the information for the curr user
    $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);

    if ($_REQUEST['submit'] == 'logout' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        unset($_SESSION['usrInfo']);
    } else if ($_REQUEST['submit'] == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['usrInfo'] = login($_REQUEST['username'], $_REQUEST['password']);
    } else if ($_REQUEST['submit'] == 'newU' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        //make a new user
        newUser($_REQUEST['nusrID'], $_REQUEST['nperms'], $_REQUEST['nfirstname'], $_REQUEST['nlastname'], $_REQUEST['npassword'], $_REQUEST['nusername']);
        //re get max user id
        $max = getMaxUserID();
        //re get all users to show updates
        $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && (strpos($_REQUEST['submit'], 'update') !== false || strpos($_REQUEST['submit'], 'delete') !== false)) {

        //check to see if there is more then one user in info
        //if there is it loops through all of them and diaplayes them
        //if their is not it drops down into seperate else
        if (sizeof($info[2]) != 1) {
            foreach ($info[2] as $item) {

                //get the current user id for each is on
                $currPos = $item->userID;

                if ($_REQUEST['submit'] == ('update' . $currPos)) {
                    (($_SESSION['usrInfo'][2]->perms == 1) ? $up = $_REQUEST['perms' . $currPos] : $up = $_SESSION['usrInfo'][2]->perms);
                    updateUser($_REQUEST['usrID' . $currPos], $up, $_REQUEST['firstname' . $currPos], $_REQUEST['lastname' . $currPos], $_REQUEST['password' . $currPos], $_REQUEST['username' . $currPos]);
                    $max = getMaxUserID();
                    $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);
                } else if ($_REQUEST['submit'] == 'delete' . $currPos) {
                    delUser($item->userID);
                    $max = getMaxUserID();
                    $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);
                }
            }
        } else {
            //since only one user is in the DB it must be the curr user logged in
            //show the curr users infromation
            $currPos = $_SESSION['usrInfo'][2]->userID;
            if ($_REQUEST['submit'] == ('update' . $currPos)) {
                updateUser($_REQUEST['usrID' . $currPos], (($_SESSION['usrInfo'][2]->perms == 1) ? $_REQUEST['perms' . $currPos] : $_SESSION['usrInfo'][2]->perms), $_REQUEST['firstname' . $currPos], $_REQUEST['lastname' . $currPos], $_REQUEST['password' . $currPos], $_REQUEST['username' . $currPos]);
                $max = getMaxUserID();
                $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);
            } else if ($_REQUEST['submit'] == 'delete' . $currPos) {
                delUser($currPos);
                $max = getMaxUserID();
                $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);
            }
        }

    }
}

//make sure to include the header, if not found throw error
require_once "templates/header.php";

?>
<div class="admin body-style">
    <?php
    //check to make sure a user is logged in
    if ($_SESSION['usrInfo'][0] == true) {
        $info = ($_SESSION['usrInfo'][2]->perms == 1) ? getAllUsers() : getSpecificUser($_SESSION['usrInfo'][2]->userID);


        ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <?php
        //check to see if the user is an admin
        if ($_SESSION['usrInfo'][2]->perms == 1) {

            //if he is loop through all of the users
            foreach ($info[2] as $item) {
                //the current user id currently being worked on
                $pos = $item->userID;
                ?>
                <p class="seperator">
                    <?php
                    //display what type the user is
                    if ($item->perms == 1) {
                        print "Admin";
                    } else if ($item->perms == 2) {
                        print "Editor";
                    } else {
                        print "Not Defined";
                    }
                    //i dynamically create textarea names by appending the userid
                    ?>
                    User ID
                    <textarea name="<?php print 'usrID' . $pos ?>"
                              readonly="readonly"><?php print $item->userID; ?></textarea>
                    First Name:
                    <textarea
                        name="<?php print 'firstname' . $pos ?>"><?php print $item->firstName; ?></textarea>
                    Last Name:
                    <textarea
                        name="<?php print 'lastname' . $pos ?>"><?php print $item->lastName; ?></textarea>
                    username:
                    <textarea
                        name="<?php print 'username' . $pos ?>"><?php print $item->username; ?></textarea>
                    Password:
                    <textarea
                        name="<?php print 'password' . $pos ?>"><?php print $item->password; ?></textarea>
                    Permissions:
                    <select name="<?php print 'perms' . $pos ?>">
                        <option value="1"<?php (($item->perms == 1) ? print "selected" : "") ?>>Admin</option>
                        <option value="2"<?php (($item->perms == 2) ? print "selected" : "") ?>>Editor</option>
                    </select>
                    <button type="submit" name="submit" value="<?php print "update" . $pos ?>">update</button>

                    <?php
                    //construct the string for the del user button
                    $usr2Delete = "delete" . $pos;
                    ($_SESSION['usrInfo'][2]->userID == $item->userID) ? "" : print  "<button type=\"submit\" name=\"submit\" value=\"$usr2Delete\">delete user</button>";

                    ?>


                </p>
                <?php
            }
            ?>

            </form>

            <!--new form for a new user-->
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                User ID
                <textarea name="nusrID" readonly="readonly"><?php print $max[2]->uidMAX + 1 ?></textarea>
                First Name:
                <textarea name="nfirstname" required></textarea>
                Last Name:
                <textarea name="nlastname" required></textarea>
                username:
                <textarea name="nusername" required></textarea>
                Password:
                <textarea name="npassword" required></textarea>
                Permissions:
                <select name="nperms">
                    <option value="1">Admin</option>
                    <option value="2">Editor</option>
                </select>
                <button type="submit" name="submit" value="newU">New User</button>
            </form>
            <?php

        } else {
            //drop into here if the curr user logged in is not an admin
            //this makes it to the curr user can only edit their own infomation
            $info = getSpecificUser($_SESSION['usrInfo'][2]->userID);

            ?>
            <p class="seperator">
                <?php
                if ($info[2]->perms == 1) {
                    print "Admin";
                } else if ($info[2]->perms == 2) {
                    print "Editor";
                } else {
                    print "Not Defined";
                }
                ?>

                User ID
                <textarea name="<?php print 'usrID' . $info[2]->userID ?>"
                          readonly="readonly"><?php print $info[2]->userID; ?></textarea>
                First Name:
                <textarea
                    name="<?php print 'firstname' . $info[2]->userID ?>"><?php print $info[2]->firstName; ?></textarea>
                Last Name:
                <textarea
                    name="<?php print 'lastname' . $info[2]->userID ?>"><?php print $info[2]->lastName; ?></textarea>
                username:
                <textarea name="<?php print 'username' . $info[2]->userID ?>"
                ><?php print $info[2]->username; ?></textarea>
                Password:
                <textarea
                    name="<?php print 'password' . $info[2]->userID ?>"><?php print $info[2]->password; ?></textarea>
                Permissions:
                <select name="<?php print 'perms' . $info[2]->userID ?>" disabled>
                    <option value="1">Admin</option>
                    <option value="2" selected>Editor</option>
                </select>
                <button type="submit" name="submit" value="<?php print "update" . $info[2]->userID ?>">update</button>

            </p>
            <?php
        }

    } else {

        print "<p>ACCESS DENIED!</p>";
    }
    ?>
    <?php

    //require the footer, if not found error out
    require_once "templates/footer.php";
    ?>

<?php
//include "classInfo.php";

//start the session.


//credentials to log into the database
//if you are unable to log in and want to change this to your local machine.
//you will need to change username, password, host, and db name here.
define('username', 'replaceme');
define('password', 'replaceme');
define('host_db', 'mysql:host=localhost;dbname=CMS;charset=utf8');

/**
 *log in function.
 * this function accepts the email and the account number to check against the database
 *
 * it returns an array with if it was successful
 * error/success message
 * and an object of what was returned from the query
 *
 * more info on PHP PFO \|/
 * https://code.tutsplus.com/tutorials/php-database-access-are-you-doing-it-correctly--net-25338
 */
function login($username, $password)
{
//TODO hash and salt password    
    //try the query
    try {

        //establish PDO connection string
        $conn = new PDO(host_db, username, password);

        /*
         * set PDO error mode
         * ATTR_ERRMODE enables error reporting
         * ERRMODE_EXCEPTION will allow it to throw exceptions to be caught
         */
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*
         * prepare the statement to be executed by the sql server.
         * items in the query with : are parameters that can be specified by the programmer
         */
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = (:usr) AND password = (:ps)');

        //bind my value to the :usr parameter
        $stmt->bindParam(':usr', $username);

        //bind my value to the :ps parameter
        $stmt->bindParam(':ps', $password);

        //execute the query
        $stmt->execute();

        //fetch the results of the query, this will store an object into $row
        //*SIDE NOTE* FETCH_LAZY is an option and it does the same thing but with lazy loading
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        //check to see if any rows were found
        if ($stmt->rowCount() > 0) {
            $conn = null;
            //if they are return everything
            return [true, 'update successful!', $row];
        } else {

            $conn = null;

            //if not return error
            return [false, 'error could not update!'];
        }

        //closing the pdo
    } //catch all errors and return the error
    catch (PDOException $e) {
        //return the error message
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }

}

function updateArticles($arNum, $auth, $title, $bod)
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('UPDATE pages SET author = (:att), title = (:tl), body = (:bd), modified = now() WHERE pgID = (:an)');
        $stmt->bindParam(':att', $auth);
        $stmt->bindParam(':tl', $title);
        $stmt->bindParam(':bd', $bod);
        $stmt->bindParam(':an', $arNum);

        //run the query


        //if this query runs with no errors it returns true
        if ($stmt->execute()) {
            $conn = null;

            return [true, 'update successful!'];
        } else {
            $conn = null;

            return [false, 'error could not update'];
        }

    } catch (PDOException $e) {
        $conn = null;

        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getArticlesOfType($arNo)
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT * FROM pages WHERE pgType = (:num)');
        $stmt->bindParam(':num', $arNo);

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getMaxUserID()
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare(' select MAX(userID) AS uidMAX from users');

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }

    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getMaxPageID()
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare(' select MAX(pgID) AS pgMAX from pages');

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getNumArticles()
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT COUNT(pgID) AS pgCt FROM pages');

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getNumArticlesOfType($type)
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT COUNT(pgType) AS numPg FROM pages WHERE pgType = (:pgty)');
        $stmt->bindParam(':pgty', $type);

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getArticle()
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT * FROM pages');

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getSpecificArticle($arNo)
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT * FROM pages WHERE pgID = (:num)');
        $stmt->bindParam(':num', $arNo);

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function newArticle($pi, $pe, $tw, $ar, $by, $pd, $s)
{
    try {

        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('INSERT INTO pages VALUES((:pi), (:pe), (:tw), (:ar), (:bd), NOW(), (:pd), (:s))');
        $stmt->bindParam(':pi', $pi);
        $stmt->bindParam(':pe', $pe);
        $stmt->bindParam(':tw', $tw);
        $stmt->bindParam(':ar', $ar);
        $stmt->bindParam(':bd', $by);
        $stmt->bindParam(':pd', $pd);
        $stmt->bindParam(':s', $s);


        //run the query


        //get what was selected as an object
        if ($stmt->execute()) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!'];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }

}

function getArticleStatus($arNo)
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT * FROM pages WHERE pgID = (:ao)');
        $stmt->bindParam(':ao', $arNo);

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function toggleArticleStatus($arNo)
{
    try {
        //status is either a 1 or a 0.
        //i to flip it i subtract one and get its absolute value
        //for example if it is currently 0. it takes 1 away (-1)
        //then takes the absolute value which makes it 1
        $flip = abs(getArticleStatus($arNo)[2]->active - 1);

        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('UPDATE pages SET active = (:fp) WHERE pgID = (:pd)');
        $stmt->bindParam(':fp', $flip);
        $stmt->bindParam(':pd', $arNo);

        if ($stmt->execute()) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!'];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getNumUsers()
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT COUNT(userID) AS numUsr FROM users');

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {

            return [true, 'update successful!', $row];
        } else {
            return [false, 'error could not update2'];
        }

        // //closing the pdo
        $conn = null;
    } catch (PDOException $e) {
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getSpecificUser($uId)
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT * FROM users WHERE userID = (:usrID)');
        $stmt->bindParam(':usrID', $uId);

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function getAllUsers()
{
    try {
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('SELECT * FROM users');

        //run the query
        $stmt->execute();

        //get what was selected as an object
        $row = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!', $row];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update22'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function updateUser($uID, $p, $fn, $ln, $pw, $un)
{
    try {

        //get all the information for the current user
        $currUser = getSpecificUser($uID)[2]->userID;

        //if for what ever reason a field is blank
        //use what value it is currently set to in the DB
        if (empty($p)) {
            $p = $currUser[2]->perms;
        }
        if (empty($fn)) {
            $fn = $currUser[2]->firstName;
        }
        if (empty($ln)) {
            $ln = $currUser[2]->lastName;
        }
        if (empty($pw)) {
            $pw = $currUser[2]->password;
        }
        if (empty($un)) {
            $un = $currUser[2]->username;
        }
        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('UPDATE users SET perms = (:ps), firstName = (:fe), lastName = (:le), password = (:pd), username = (:ue) WHERE userID = (:ud)');
        $stmt->bindParam(':ps', $p);
        $stmt->bindParam(':fe', $fn);
        $stmt->bindParam(':le', $ln);
        $stmt->bindParam(':pd', $pw);
        $stmt->bindParam(':ue', $un);
        $stmt->bindParam(':ud', $uID);


        //run the query


        //get what was selected as an object
        if ($stmt->execute()) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!'];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function newUser($uID, $p, $fn, $ln, $pw, $un)
{
    try {

        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('INSERT INTO users VALUES((:ud), (:ps), (:fe), (:le), (:pd), (:ue))');
        $stmt->bindParam(':ud', $uID);
        $stmt->bindParam(':ps', $p);
        $stmt->bindParam(':fe', $fn);
        $stmt->bindParam(':le', $ln);
        $stmt->bindParam(':pd', $pw);
        $stmt->bindParam(':ue', $un);


        //run the query


        //get what was selected as an object
        if ($stmt->execute()) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!'];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

function delUser($uID)
{
    try {

        //connect to db
        $conn = new PDO(host_db, username, password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //set up query and bind variables to it
        $stmt = $conn->prepare('DELETE FROM users WHERE userID = (:ud)');
        $stmt->bindParam(':ud', $uID);


        //run the query


        //get what was selected as an object
        if ($stmt->execute()) {
            // //closing the pdo
            $conn = null;
            return [true, 'update successful!'];
        } else {
            // //closing the pdo
            $conn = null;
            return [false, 'error could not update2'];
        }


    } catch (PDOException $e) {
        // //closing the pdo
        $conn = null;
        return [false, 'ERROR: ' . $e->getMessage()];
    }
}

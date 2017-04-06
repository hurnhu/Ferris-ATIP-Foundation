/*
Author: Michael LaPan
Professor: Hira Herrington
Course: ISYS-288-001-Fall 2016
Purpose: final project: this project is an AITP website with a semi-fully featured CMS. you can add new pages,
enable/disable pages, edit and update pages, add new users, delete users, edit users and update users.
everything has permissions, a editor cannot edit or see a page marked as admin level for permissions.
an editor can only edit their own user info and no one elses (they can not up their privileges).
admins can edit and do everything.
i have fail safes built into the users page, you can not delete the current user you are logged into.
you are also allowed to enter HTML and JS into the CMS pages and it will display correctly
you are not allowed to put PHP, this is a security risk


--==__PERFORMANCE__==--
the picture loadtest.png is a load test i preformed using loaderio. this test worked its way up to 500 concurrent people
requesting the index.txt page. My VPS is running debain, php 5.x, maria DB, 1 SHARED cpu and 2 Gb of memory.
throughout the test i had a 149MS response time, i have tweaked my server to optimize the php and mysql.
(turned on php caching, more php mem, more mysql mem, and misc. mysql tweaks)


***NOTE****
if for any reason the sql query returns an error, it will log the user out and clear all data
this is intentional, if you retrieve an error while logged in something is wrong with the server
and possible investigation will need to be done.
also it the current tab you are on does not highlight or anything this was a design decision.
also all passwords should be encrypted, but i intentionally left this out for easing development


I/O: N/A
Interfaces:


****NOTE****
some functions are not used, these functions have been phased out by newer more
efficient ones. but i did not remove them because they could be useful later in
development.


also all functions return an array, element [2] is an anonmyns object retrieved
from the query. sometimes [2] is an array of objects.
****END NOTE****


function login($username, $password) - login function
 this function takes a username and password and tries to find a user in the db
 with the same username and password. if this is found it will return true,
 and all of their information

 VARIABLES:
 $username - holds the username
 $password - holds the password
 $conn - connection string
 $stmt - sql code to run
 $row - information returned from the query

 function updateArticles($arNum, $auth, $title, $bod) - update a page function
 this function take the page's ID to update, the new author, title, and body.
 it then updates the corresponding item in the database and changes the last modify
 field to the current time and day

 VARIABLES:
 $arNum - page id to change
 $auth - new author
 $title - new title
 $bod - new body
 $conn - connection string
 $stmt - sql code to run

 function getArticlesOfType($arNo) - get all articles of a certin type
 this function takes a page type and then returns all pages of that type

  VARIABLES:
  $arNo - page id
  $bod - new body
  $conn - connection string
  $stmt - sql code to run
 $row - information returned from the query

function getMaxUserID() - get the maximum user id
this function returns max userid in the users table

  VARIABLES:
   from here on out i will not be describing $conn, $stmt, or $row
   their function is the same throughout all functions.

   function getMaxPageID() - get the maximum page id
   this function returns max pageid in the pages table

function getNumArticles() - gets how many pages in total their are
this function returns a count of all pages.

function getNumArticlesOfType($type) - returns how many pages of the supplied
type exist in the db

VARIABLES:
$type - page type

function getArticle() - returns all of the pages
this functions will return all pages that are in the pages db

function getSpecificArticle($arNo) - returns a specific page
this function takes the pageid you will like to get form the db

VARIABLES:
$arNo - page id to find and return

function newArticle($pi, $pe, $tw, $ar, $by, $pd, $s) - makes a new article
this function takes all of the info to make a new article

VARIABLES:
$pi - page id
$pe - page type
$tw - page title
$ar - page author
$by - page body
$pd -page permissions
$s - page status

function getArticleStatus($arNo) - get the current status of a page
pages can be disabled (does not show up on front end) or enabled.
this functions returns the pages status

VARIABLES:
$arNo - page id

function toggleArticleStatus($arNo) - this function flips the article status
from enable to disabled

VARIBLES:
$arNo - page id
$flip - the opposite status of the page

function getNumUsers() - count how many users their are

function getSpecificUser($uId)
this functions returns all the information pertaining to a specific user

VARIABLES:
$uID - user id

function getAllUsers()
this function returns all of the information for all of the users in the db


function updateUser($uID, $p, $fn, $ln, $pw, $un)
this function updates a specific users information

VARIABLES:
$uID - user id (the user is unable to change this)
$p - permissiosn of the usr
$fn - users first name
$ln - users last name
$pw - the users password (unencrypted, this is intentional for development)
$un - username


function newUser($uID, $p, $fn, $ln, $pw, $un)
this function makes a new user

VATIBLES:
$uID - user id (the user is unable to change this)
$p - permissiosn of the usr
$fn - users first name
$ln - users last name
$pw - the users password (unencrypted, this is intentional for development)
$un - username


function delUser($uID)
delete a specific user

VARIABLES:
$uID - user id





Variables:

$_SESSION['usrInfo']
this will hold all of the users info that is currently logged in

$info
this will hold all of the infomation for the for each loop to loop through

$max
this will either hold the max page id or the max user id in the db

$item
the current item the for each is on

$currPos
the current pgID or userID in the for each loop

$pos
holds the current pgID or userID in the for each loop

$t
holds the page type

$arinfo
hold all of the information for a specific page type

$to
email address to send the email

$subject
the subject of the email

$message
the message body

$header
the headers for the email

$mail
send the mail and store weather if failed or now

$up
temp holder for user perms

*/


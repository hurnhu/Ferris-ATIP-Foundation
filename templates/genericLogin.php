<?php
//check to see if the logout button was pushed and it was a post event
if ($_REQUEST['submit'] == 'logout' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    //if it was unset all users info
    unset($_SESSION['usrInfo']);

} else if ($_REQUEST['submit'] == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    //if login button was pressed and is post even drop in here

    //get and store all of the users info
    $_SESSION['usrInfo'] = login($_REQUEST['username'], $_REQUEST['password']);

} else if ($_REQUEST['submit'] == 'contactF' && $t == 7 && $_SERVER['REQUEST_METHOD'] == 'POST') {
//check to see if the contacn button was pushed, and its on the contact page (7) and it is a post evem

    //check to make sure numVal contains numbers and texVal contains text
    if (is_numeric($_REQUEST['numVal']) && ctype_alpha($_REQUEST['textVal'])) {
        //building all of the email info
        $to = "hurnhu@michaellapan.com";
        $subject = $_REQUEST['subject'];
        $message = "From: " . $_REQUEST['userName'] . "\n" . $_REQUEST['message'];
        $header = "From:" . $_REQUEST['userEmail'] . "\r\n";

        //send the info
        $mail = mb_send_mail($to, $subject, $message, $header);

        //check if send mail was successful
        if ($mail) {

            //display alert
            ?>
            <script type="text/javascript">
                alert("Your Email has been sent!");
            </script>
            <?php
        } else {
            //if send mail error, show error
            ?>
            <script type="text/javascript">
                alert("Email not sent!");
            </script>
            <?php
        }
    } else {
        //catch all other unknown errors
        ?>
        <script type="text/javascript">
            alert("Email not sent! Unknown error!");
        </script>
        <?php
    }
}

?>
<?php
//check to make sure the pages were retrived from the db without errors
if ($arinfo[0] == true) {
    //loop through each item in arinfo[2]
    //arinfo[2] will contain all of the pages contents
    foreach ($arinfo[2] as $item) {

        //check to see if the page is active
        if ($item->active) {
            //if it is display the title, author, and body
            print $item->title;
            print $item->author;

            //check to see if $random is in the body, if it is replace it with a random number and display the body
            //if it is not just display the body
            (strpos('$random', $item->body)) ? print $item->body : print str_replace('$random', rand(-999, 999), $item->body);

            //display the lasy modified date
            print "<p class=\"smallText modify\">Last Updated: " . $item->modified . "</p>";

        }
    }
} else {
    //display the mysql error if query failed
    print $arinfo[1];
}

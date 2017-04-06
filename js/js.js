/**
 *
 * http://www.w3schools.com/w3css/w3css_slideshow.asp
 *
 *
 * */

//add one to slide index to switch pictures
function plusDivs(n) {
    showDivs(slideIndex += n);
}

//the current slide iden
function currentDiv(n) {
    showDivs(slideIndex = n);
}


function showDivs(n) {
    var i;

    //get all elements with class slideM
    var x = document.getElementsByClassName("slideM");

    //check to see how many slides their are
    if (n > x.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = x.length
    }

    //loop through the slide to move it by one
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    x[slideIndex - 1].style.display = "block";
}
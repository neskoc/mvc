/* jshint esversion: 8 */
/* jshint node: true */

"use strict";

// utils.js

function validateForm() {
    let radios = document.getElementsByName("dice");
    let formValid = false;

    let i = 0;
    while (!formValid && i < radios.length) {
        if (radios[i].checked) {
            formValid = true;
        }
        i++;        
    }

    if (!formValid) {
        alert("Du måste välja en rad!");
    }
    return formValid;
}

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/app.scss';
// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');



window.send = function send (id) {
    if(confirm("Are you sur to deleting this post ?")){
        document.getElementById(`delete-form-${id}`).submit();
    }
};

window.edit = function edit (id) {
    if(confirm("Are you sur to edit this post ?")){
        document.getElementById(`edit-form-${id}`).submit();
    }
};

document.getElementById("button-user-edit").onclick = function () {
    if(confirm("Are you sur to edit your profil ?")){
        document.getElementById("user-edit").submit();
    }
}
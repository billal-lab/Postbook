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

try {
    document.getElementById("button-user-edit").onclick = function () {
        if(confirm("Are you sur to edit your profil ?")){
            document.getElementById("user-edit").submit();
        }
    }
} catch (error) {
    
}

var  messageTopics = document.querySelectorAll('#messageTopic');
var  messageLinks = document.querySelectorAll('#messageLink');

var i=0;
for(i=0;i<messageLinks.length;i++){
    (function work(j) {
        messageLinks[j].addEventListener("click",(event)=>{
            event.preventDefault();
            var sib = messageLinks[j].nextElementSibling
            if(sib.classList.toggle("hide")===false){
                messageLinks[j].childNodes[0].textContent = "Hide content"
            }else{
                messageLinks[j].childNodes[0].textContent = "dispaly message content"
            }
        })
    })(i)
}


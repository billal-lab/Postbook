import { event } from "jquery";

var createRequest = function () {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for old IE browsers
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
     }
     return xmlhttp;
 }

 var xhttp = createRequest();

 document.querySelectorAll("#like").forEach((like)=>{
    like.addEventListener('click',(event)=>{
        event.preventDefault();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var vJson = JSON.parse(xhttp.responseText);
              like.innerHTML = vJson.action
              like.nextElementSibling.innerHTML = vJson.nbLike + " Likes";
            }
        };
        xhttp.open("GET", like.href , true);
        xhttp.send();
    });
 });

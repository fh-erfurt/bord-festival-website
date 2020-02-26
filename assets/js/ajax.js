// function ajaxPost() {
//     var newName = 'John Smith',
//         xhr = new XMLHttpRequest();

//     xhr.open('POST', 'index.php?c=order&a=shop&t=tickets');
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.onload = function() {
//         if (xhr.status === 200 && xhr.responseText !== newName) {
//             alert('Something went wrong.  Name is now ' + xhr.responseText);
//         }
//         else if (xhr.status !== 200) {
//             alert('Request failed.  Returned status of ' + xhr.status);
//         }
//     };
//     xhr.send(encodeURI('name=' + newName));
// }

// Hide shoppingcart-buttons for normal PHP-Posting when JavaScript is working
window.onload = function () {
    var elementsToHide = document.getElementsByClassName("hide-js-enabled");
    for(var i = 0; i < elementsToHide.length; i++){
        elementsToHide[i].style.display = "none";
    }
};

// Send a POST with AJAX to add items to cart
function postCartWithAjax(itemid, itemcountelement) {    
    var itemcount = parseInt(document.getElementById(itemcountelement).value);
    var url = 'index.php?c=order&a=shop&t=tickets&addtocart=true&json=true';
    var data = 'itemid='+itemid+'&itemcount='+itemcount+'&additemtocart=';
    var params = typeof data == 'string' ? data : Object.keys(data).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
        ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) { 
            console.log(xhr.responseText);
            if(xhr.responseText == 1) {
                var element = document.getElementById('ajaxsuccess');
                fadeIn(element);
            } else if(xhr.responseText == 2) {
                var element = document.getElementById('ajaxwarning');
                fadeIn(element);
            } else {
                var element = document.getElementById('ajaxerror');
                fadeIn(element);
            }
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
}
function fadeIn(element) {
    element.style.position = 'relative';
    element.style.visibility = 'visible';
    element.style.opacity = 1;
    setTimeout(function() {fadeOut(element)}, 5000 );
}
function fadeOut(element) {    
    element.style.visibility = 'hidden';
    element.style.opacity = 0;
    setTimeout(function() {hide(element)}, 700 );
}
function hide(element) {
    element.style.position = 'absolute';
}

function getAjax() {
    var url = 'index.php?c=order&a=shop&t=tickets&calculatecart=true&json=true';
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    xhr.open('GET', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) {
            console.log(xhr.responseText);

        } 
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
    return xhr;
}

// example request
//postAjax('http://foo.bar/', 'p1=1&p2=Hello+World', function(data){ console.log(data); });
/*
document.addEventListener('DOMContentLoaded', function(){
    event.stopPropagation(); // no send to the top element
    event.preventDefault(); // no default action on submit

    var request = new XMLHttpRequest();
    request.open('get', '?json=1', true);

    request.onreadystatechange = function() {
        // request finished?
        if(this.readyState == 4) // XMLHttpRequest.DONE
        {
            // HTTP-Status-Code is OK?
            if(this.status == 200)
            {
                var resJson = null;
                try
                {
                    resJson = JSON.parse(this.response);
                    console.log(resJson);
                }
                catch(err)
                {

                    console.log(error);
                }
                
                if(resJson !== null)
                {
                    if(resJson.error !== null)
                    {
                        console.log(error);
                    }
                    else
                    {
                        errorBox.style.display = 'none';
                    }
                }
            }
            else
            {
                console.log(this.statusText);
            }
        }
    }
});

*/
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
    setTimeout(function() {getCalculatedCart()}, 300 );
    return xhr;
}

// hide/show messages for added cartitems
function fadeIn(element) {
    element.style.position = 'relative';
    element.style.visibility = 'visible';
    element.style.marginLeft = 'inherit';
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

// Calculate Cart dynamically with AJAX when items got added to the cart
function getCalculatedCart() {
    var url = 'index.php?c=order&a=shop&t=tickets&calculatecart=true&json=true';
    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    xhr.open('GET', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) {
            var obj = JSON.parse(xhr.responseText);
            console.log(obj);
            var cartcount = document.getElementById('carttotalcount');
            var cartprice = document.getElementById('carttotalprice');
            cartcount.innerHTML = obj['cartTotalCount'];
            cartprice.innerHTML = obj['cartTotalPrice'] + ' €';
        } 
        if (obj['cartTotalCount'] > 0) {
            document.getElementById('hide-empty-cart').style.display = 'inline';
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
    return xhr;
}
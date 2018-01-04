function checkCookiesEnabled() {

    var x = navigator.cookieEnabled;
    if (navigator.cookieEnabled == false){
      //document.getElementById("demo").innerHTML = x;
    alert("Cookies are are required for login but are not enabled.  Please enable cookies and try again");

    }
    
}
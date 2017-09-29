/* 	*************************************************************************************
	script retrieved from:  https://gist.github.com/gerard-kanters/2ce9daa5c23d8abe36c2
	script name: .......... inactivity.js
	by: ................... gerard-kanters

***************************************************************************************** */

function idleTimer() {
    var t;
    window.onload = resetTimer;
    window.onmousemove = resetTimer; // catches mouse movements
    window.onmousedown = resetTimer; // catches mouse movements
    window.onclick = resetTimer;     // catches mouse clicks
    window.onscroll = resetTimer;    // catches scrolling
    window.onkeypress = resetTimer;  //catches keyboard actions
    window.ontouchstart = resetTimer;  //catches phone tablet touch actions

    function logout() {
        window.location.href = '/logout.php';  //Adapt to actual logout script
    }

   function reload() {
          window.location = self.location.href;  //Reloads the current page
   }

   function resetTimer() {
        clearTimeout(t);
        t = setTimeout(logout, 1000*60*10);  // time is in milliseconds (1000 is 1 second)
        									// milliseconds per second * seconds per minute * minutes
        									// to change inactivity duration, change the minutes only
      //  t= setTimeout(reload, 3000);  // time is in milliseconds (1000 is 1 second)
    }
}
idleTimer();
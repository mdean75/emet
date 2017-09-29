Documentation and coding standards

Forms
	Cancel button
		use javascript window.history.go(-1)
	back button
		use javascript window.history.go(-1)

redirects
 	when possible use header
 		utility class		
 			redirect - instant redirect
 			refresh - time delay
 	when need to prevent back button loop
 		use javascript window.replace(url)

Classes
	autoloading
		class library file directory: web-root/resources/class-lib/
		include /resources/autoloader.php file on each page that requires classes

	class definition structure
		constructor method first listed method
		next comes any static method
		other methods after the static methods

Status codes for redirects (instead of ?error='xyz' or ?redirect='abc' use ?status-code='abcxyz')
	send status codes instead of clear text
		first 4 digits indicate severity (success, warning, error)
		next 4 digits indicate message (invalid entry, no match, redirect)
			success	2x99-success

			redirect 3x99-redirect

			user error 4x99-error

			server error 5x99-failure


Security
	login
		brute force attacks can send hundreds of requests per minute from the same or different ip addresses using the same or different user accounts. Several issues arise when trying to secure the application against these attacks. Ip address are not a reliable way to track a user trying to authenticate or an attacker as depending on how the internet service provider (ISP) system is set up, a legitimate user may have multiple IP's during the same session.  Likewise, it is common for a group of users, for example under the same lan, to have the same IP address. Cookies can be troublesome as well, and keep in mind that sessions, and in particular secure sessions, will utilize cookies. Users can freely disable cookies on their browser, rendering this type of tracking useless and also making it impossible to use cookie only sessions. Also, if using sessions and user or attacker gets locked out due to number of invalid attempts, all they have to do is close their browser and reopen it or figure out which cookie is storing the session and delete that information. User agen (UA) is consider a better indicator of an individual making multiple authentication attempts from the same computer. The caveat with UA is that each browser on a given computer will have a different UA. A common practice is to lock the user account that is being used to attempt to authenticate, however this can result in denial of service (DOS) for that user and also doesn't help if the user or attacker is not using a valid account.
		As you can see, there is no single good way to secure the application against brute force attackers. As a result, securing the application must be a multi step process. Since these attackers typically use scripts that run a high number of attempts in a short period, one of the best security steps is to increase the time between attempts in a way that makes it inconvenient for attackers but unnoticed by valid users. The first steps are time delays.
			1) By using php sleep() add a small delay after a failed login attempt

			2) After 3 failed login attempts present a simple captcha 
				note: technology and hackers have become advanced enough that even the best captcha's can be broken relatively quickly, however it add an additional time delay component for attackers

			3) Perform checks that cookies are set
				note: start sessions in the header so every page has sessions, then set a cookie on login page and check for that cookie on the login action. If the cookie does not exist, then cookies are disabled. Stop the login script and let user know that cookies are required. This can also be accomplished within the same page by utilizing javascript to check if cookies are enabled. However, be cautious using javascript as the user can also turn that off in their browser.

			4) Track attempts by using a combination of ... to be determined ... 


Template files
	admin-header.php 
		included in every file except login.php and index.php
		starts the session, regenerates sesssion id if set time has elapsed and includes 	footer and mmenu 
		has the page title, logo as back button, logged in user and logout button
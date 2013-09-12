Sign-Up-Form
=============

###A quick form to be used in any websites. Now with client & server validation using ajax.

####Dependency:
> - jquery 1.10.2
> - jquery validate [http://jqueryvalidation.org/]
> - php 5.4 & above
> - PHPMailer [https://github.com/PHPMailer/PHPMailer]

####Settings to change:
> **NOTE:** Below are the settings to change according to project:
>
> - Change error label and form styles in CSS & HTML
> - Remove comments in contact.php & custom.js file
> - Add loader.gif into images/ folder

#####File: contact.php
```
$privatekey = "GET_THE_PRIVATE_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE";

// email configuration:
$mail->SMTPDebug = false;
$mail = new PHPMailer(true);
$mail->Subject = "ADD_YOUR_EMAIL_SUBJECT_HERE";
```

-----------------------------------------------------------------------

#####File: js/custom.js
```
function showRecaptcha(element) {
    Recaptcha.create("GET_THE_PUBLIC_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE", element, {
        theme: "white"
    });
}showRecaptcha("captcha-test");
```

-----------------------------------------------------------------------

#####File: include/configz.php
```
/**
 * @author ScarLight
 * @copyright 2011
 */

defined('ADMIN1EMAIL')? null : define('ADMIN1', 'PERSONAL_EMAIL_TO_TEST');
defined('ADMIN1NAME') ? null : define('ADMIN1NAME', 'PERSONAL_NAME');
defined('ADMIN2EMAIL')? null : define('ADMIN2', 'CUSTOMER_EMAIL_OR_DEFAULT_DOMAIN_EMAIL');
defined('ADMIN2NAME') ? null : define('ADMIN2NAME', 'CUSTOMER_NAME_OR_DOMAIN');
defined('MAILPORT')   ? null : define('MAILPORT', 465);
defined ('MAILHOST')  ? null : define('MAILHOST', 'NAME_OF_MAILHOST_USING_SSL');
defined ('MAILFROM')  ? null : define('MAILFROM', 'CUSTOMER_EMAIL_OR_DEFAULT_DOMAIN_EMAIL');
defined('MAILUSER')   ? null : define('MAILUSER', 'CUSTOMER_EMAIL_OR_DEFAULT_DOMAIN_EMAIL');
defined('MAILPASS')   ? null : define('MAILPASS', 'CUSTOMER_EMAIL_OR_DEFAULT_DOMAIN_EMAIL_PASSWORD');

//localhost setting for testing
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITEROOT') ? null : define('SITEROOT', 'C:/xampp/htdocs/sites/sandbox/THE_FOLDER');
defined('LIBRARY') ? null : define('LIBRARY', SITEROOT.DS.'include');

//live host setting
//defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
//defined('SITEROOT') ? null : define('SITEROOT', DS.'home'.DS.'THE_CUSTOMER_DOMAIN'.DS.'THE_PUBLIC_FOLDER');
//defined('LIBRARY') ? null : define('LIBRARY', SITEROOT.DS.'include');

require_once(LIBRARY.DS.'configz.php');
require_once(LIBRARY.DS.'Util.php');
require_once(LIBRARY.DS.'PHPMailer'.DS.'class.phpmailer.php');
require_once(LIBRARY.DS.'PHPMailer'.DS.'class.smtp.php');
require_once(LIBRARY.DS.'PHPMailer'.DS.'class.pop3.php');
require_once(LIBRARY.DS.'recaptchalib.php');
```

####TODO:
- Clean form style to be more generic then its easier to edit the CSS in other project.
- Provide standard css selector choice in custom.js for portability.
- Remove restrictive error label placements in custom.js.
- Standardise JSON parameters when requesting from server, then match it to form's input name attribute
- Isolate functions in feedback.php to meaningful classes.
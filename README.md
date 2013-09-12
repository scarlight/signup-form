Sign-Up-Form
=============

###An quick form to be used in websites. Comes with client & server validation with ajax

####Settings to change:

```
file: contact.php

$privatekey = "GET_THE_PRIVATE_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE";

// email configuration:
$mail->SMTPDebug = false;
$mail = new PHPMailer(true);
$mail->Subject = "ADD_YOUR_EMAIL_SUBJECT_HERE";

-----------------------------------------------------------------------

file: js/custom.js

function showRecaptcha(element) {
    Recaptcha.create("GET_THE_PUBLIC_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE", element, {
        theme: "white"
    });
}showRecaptcha("captcha-test");

-----------------------------------------------------------------------

file: include/configz.php

/**
 * @author ScarLight
 * @copyright 2011
 */

defined('ADMIN1EMAIL')     ? null : define('ADMIN1', 'PERSONAL_EMAIL_TO_TEST');
defined('ADMIN1NAME') ? null : define('ADMIN1NAME', 'PERSONAL_NAME');
defined('ADMIN2EMAIL')     ? null : define('ADMIN2', 'CUSTOMER_EMAIL_OR_DEFAULT_DOMAIN_EMAIL');
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


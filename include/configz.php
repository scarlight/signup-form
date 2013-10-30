<?php

/**
 * @author ScarLight
 * @copyright 2011
 */

defined('ADMIN1EMAIL')? null : define('ADMIN1EMAIL', 'CLIENT_EMAIL');
defined('ADMIN1NAME') ? null : define('ADMIN1NAME', 'CLIENT_NAME');
defined('ADMIN2EMAIL')? null : define('ADMIN2EMAIL', 'MY_EMAIL');
defined('ADMIN2NAME') ? null : define('ADMIN2NAME', 'MY_NAME');
defined('MAILPORT')   ? null : define('MAILPORT', 465);
defined ('MAILHOST')  ? null : define('MAILHOST', 'MAILHOST_NAME_USING_SSL');
defined ('MAILFROM')  ? null : define('MAILFROM', 'ASSIGNED_EMAIL_FOR_THE_WEBSITE_FORM');
defined('MAILUSER')   ? null : define('MAILUSER', 'THE_WEBSITE_URL_WIH_NO_WWW');
defined('MAILPASS')   ? null : define('MAILPASS', 'ASSIGNED_EMAIL_FOR_THE_WEBSITE_FORM_PASSWORD');

//localhost setting for testing
defined('DS')         ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITEROOT')   ? null : define('SITEROOT', 'C:/xampp/htdocs/sites/sandbox/THE_FOLDER');
defined('LIBRARY')    ? null : define('LIBRARY', SITEROOT.DS.'include');

//live host setting
//defined('DS')       ? null : define('DS', DIRECTORY_SEPARATOR);
//defined('SITEROOT') ? null : define('SITEROOT', DS.'home'.DS.'THE_CUSTOMER_DOMAIN'.DS.'THE_PUBLIC_FOLDER');
//defined('LIBRARY')  ? null : define('LIBRARY', SITEROOT.DS.'include');

require_once(LIBRARY.DS.'configz.php');
require_once(LIBRARY.DS.'Util.php');
require_once(LIBRARY.DS.'PHPMailer'.DS.'class.phpmailer.php');
require_once(LIBRARY.DS.'PHPMailer'.DS.'class.smtp.php');
require_once(LIBRARY.DS.'PHPMailer'.DS.'class.pop3.php');
require_once(LIBRARY.DS.'recaptchalib.php');

?>
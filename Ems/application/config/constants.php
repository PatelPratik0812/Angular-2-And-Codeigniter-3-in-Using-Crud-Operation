<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('SYSTEM_LOGO_EMAIL') OR define('SYSTEM_LOGO_EMAIL', 'http://192.168.1.226:8086/scrapcall2/html/templates/images/logo_header.png');
defined('MAIL_ADDRESS') OR define('MAIL_ADDRESS', 'bhavik.panchal123@gmail.com');
/*defined('MAIL_ADDRESS')      OR define('MAIL_ADDRESS', 'kashyap@coronation.in');*/
define("ALLOWED_DOMAIN", serialize(array(
    "localhost:4200",
    "scrapcall.com",
    "139.59.62.59",
    "192.168.1.243:8090"
)));

defined('ACTIVE') OR define('ACTIVE', 'Active');

/******** Pages constants  *********/

defined('ACTIVESTATUS') OR define('ACTIVESTATUS', 'Active');
defined('INACTIVESTATUS') OR define('INACTIVESTATUS', 'InActive');
defined('DELETESTATUS') OR define('DELETESTATUS', 'Delete');
defined('DUPLICATE_FOUND') OR define('DUPLICATE_FOUND', 'Dulicate record found');

/******** Quality page *************/

defined('QUALITY_LIST_NOT_FOUND') OR define('QUALITY_LIST_NOT_FOUND', 'Quality list not found');
defined('QUALITY_LIST_FOUND') OR define('QUALITY_LIST_FOUND', 'Quality list found');
defined('QUALITY_INSERT') OR define('QUALITY_INSERT', 'Quality data inserted sucessfully');
defined('QUALITY_NOT_INSERT') OR define('QUALITY_NOT_INSERT', 'Quality data not inserted sucessfully');
defined('QUALITY_UPDATE') OR define('QUALITY_UPDATE', 'Quality data updated sucessfully');
defined('QUALITY_NOT_UPDATE') OR define('QUALITY_NOT_UPDATE', 'Quality data not updated sucessfully');
defined('QUALITY_DELETE') OR define('QUALITY_DELETE', 'Quality data deleted sucessfully');
defined('QUALITY_NOT_DELETE') OR define('QUALITY_NOT_DELETE', 'Quality data not deleted sucessfully');

/********** Loom PAge **************/


defined('LOOM_LIST_NOT_FOUND') OR define('LOOM_LIST_NOT_FOUND', 'Loom list not found');
defined('LOOM_LIST_FOUND') OR define('LOOM_LIST_FOUND', 'Loom list found');
defined('LOOM_INSERT') OR define('LOOM_INSERT', 'Loom data inserted sucessfully');
defined('LOOM_NOT_INSERT') OR define('LOOM_NOT_INSERT', 'Loom data not inserted sucessfully');
defined('LOOM_UPDATE') OR define('LOOM_UPDATE', 'Loom data updated sucessfully');
defined('LOOM_NOT_UPDATE') OR define('LOOM_NOT_UPDATE', 'Loom data not updated sucessfully');
defined('LOOM_DELETE') OR define('LOOM_DELETE', 'Loom data deleted sucessfully');
defined('LOOM_NOT_DELETE') OR define('LOOM_NOT_DELETE', 'Loom data not deleted sucessfully');



defined('CODE_LIST_NOT_FOUND') OR define('CODE_LIST_NOT_FOUND', 'Code list not found');
defined('CODE_LIST_FOUND') OR define('CODE_LIST_FOUND', 'Code list found');
defined('CODE_INSERT') OR define('CODE_INSERT', 'Code data inserted sucessfully');
defined('CODE_NOT_INSERT') OR define('CODE_NOT_INSERT', 'Code data not inserted sucessfully');
defined('CODE_UPDATE') OR define('CODE_UPDATE', 'Code data updated sucessfully');
defined('CODE_NOT_UPDATE') OR define('CODE_NOT_UPDATE', 'Code data not updated sucessfully');
defined('CODE_DELETE') OR define('CODE_DELETE', 'Code data deleted sucessfully');
defined('CODE_NOT_DELETE') OR define('CODE_NOT_DELETE', 'Code data not deleted sucessfully');


/********** Mess PAge **************/

defined('MESS_LIST_NOT_FOUND') OR define('MESS_LIST_NOT_FOUND', 'Mess list not found');
defined('MESS_LIST_FOUND') OR define('MESS_LIST_FOUND', 'Mess list found');
defined('MESS_INSERT') OR define('MESS_INSERT', 'Mess data inserted sucessfully');
defined('MESS_NOT_INSERT') OR define('MESS_NOT_INSERT', 'Mess data not inserted sucessfully');
defined('MESS_UPDATE') OR define('MESS_UPDATE', 'Mess data updated sucessfully');
defined('MESS_NOT_UPDATE') OR define('MESS_NOT_UPDATE', 'Mess data not updated sucessfully');
defined('MESS_DELETE') OR define('MESS_DELETE', 'Mess data deleted sucessfully');
defined('MESS_NOT_DELETE') OR define('MESS_NOT_DELETE', 'Mess data not deleted sucessfully');

/********** Mess Incentive PAge **************/

defined('MESS_INCENTIVE_LIST_NOT_FOUND') OR define('MESS_INCENTIVE_LIST_NOT_FOUND', 'Mess Incentive list not found');
defined('MESS_INCENTIVE_LIST_FOUND') OR define('MESS_INCENTIVE_LIST_FOUND', 'Mess Incentive list found');
defined('MESS_INCENTIVE_INSERT') OR define('MESS_INCENTIVE_INSERT', 'Mess Incentive data inserted sucessfully');
defined('MESS_INCENTIVE_NOT_INSERT') OR define('MESS_INCENTIVE_NOT_INSERT', 'Mess Incentive data not inserted sucessfully');
defined('MESS_INCENTIVE_UPDATE') OR define('MESS_INCENTIVE_UPDATE', 'Mess Incentive data updated sucessfully');
defined('MESS_INCENTIVE_NOT_UPDATE') OR define('MESS_INCENTIVE_NOT_UPDATE', 'Mess Incentive data not updated sucessfully');
defined('MESS_INCENTIVE_DELETE') OR define('MESS_INCENTIVE_DELETE', 'Mess Incentive data deleted sucessfully');
defined('MESS_INCENTIVE_NOT_DELETE') OR define('MESS_INCENTIVE_NOT_DELETE', 'Mess Incentive data not deleted sucessfully');

/**********   Shift Page **********************/

defined('SHIFT_LIST_NOT_FOUND') OR define('SHIFT_LIST_NOT_FOUND', 'Shift list not found');
defined('SHIFT_LIST_FOUND') OR define('SHIFT_LIST_FOUND', 'Shift list found');
defined('SHIFT_INSERT') OR define('SHIFT_INSERT', 'Shift data inserted sucessfully');
defined('SHIFT_NOT_INSERT') OR define('SHIFT_NOT_INSERT', 'Shift data not inserted sucessfully');
defined('SHIFT_UPDATE') OR define('SHIFT_UPDATE', 'Shift data updated sucessfully');
defined('SHIFT_NOT_UPDATE') OR define('SHIFT_NOT_UPDATE', 'Shift data not updated sucessfully');
defined('SHIFT_DELETE') OR define('SHIFT_DELETE', 'Shift data deleted sucessfully');
defined('SHIFT_NOT_DELETE') OR define('SHIFT_NOT_DELETE', 'Shift data not deleted sucessfully');

/********** Loom Daily PAge **************/


defined('LOOM_DAILY_LIST_NOT_FOUND') OR define('LOOM_DAILY_LIST_NOT_FOUND', 'Loom Daily list not found');
defined('LOOM_DAILY_LIST_FOUND') OR define('LOOM_DAILY_LIST_FOUND', 'Loom Daily list found');
defined('LOOM_DAILY_INSERT') OR define('LOOM_DAILY_INSERT', 'Loom Daily data inserted sucessfully');
defined('LOOM_DAILY_NOT_INSERT') OR define('LOOM_DAILY_NOT_INSERT', 'Loom Daily data not inserted sucessfully');
defined('LOOM_DAILY_UPDATE') OR define('LOOM_DAILY_UPDATE', 'Loom Daily data updated sucessfully');
defined('LOOM_DAILY_NOT_UPDATE') OR define('LOOM_DAILY_NOT_UPDATE', 'Loom Daily data not updated sucessfully');
defined('LOOM_DAILY_DELETE') OR define('LOOM_DAILY_DELETE', 'Loom Daily data deleted sucessfully');
defined('LOOM_DAILY_NOT_DELETE') OR define('LOOM_DAILY_NOT_DELETE', 'Loom Daily data not deleted sucessfully');


defined('EMPLOYEE_LIST_NOT_FOUND') OR define('EMPLOYEE_LIST_NOT_FOUND', 'Employee list not found');
defined('EMPLOYEE_LIST_FOUND') OR define('EMPLOYEE_LIST_FOUND', 'Employee list found');
defined('EMPLOYEE_INSERT') OR define('EMPLOYEE_INSERT', 'Employee data inserted sucessfully');
defined('EMPLOYEE_NOT_INSERT') OR define('EMPLOYEE_NOT_INSERT', 'Employee data not inserted sucessfully');
defined('EMPLOYEE_UPDATE') OR define('EMPLOYEE_UPDATE', 'Employee data updated sucessfully');
defined('EMPLOYEE_NOT_UPDATE') OR define('EMPLOYEE_NOT_UPDATE', 'Employee data not updated sucessfully');
defined('EMPLOYEE_DELETE') OR define('EMPLOYEE_DELETE', 'Employee data deleted sucessfully');
defined('EMPLOYEE_NOT_DELETE') OR define('EMPLOYEE_NOT_DELETE', 'Employee data not deleted sucessfully');

defined('LIST_NOT_FOUND') OR define('LIST_NOT_FOUND', 'List not found');
defined('LIST_FOUND') OR define('LIST_FOUND', 'List found');

defined('AllREADY_USED') OR define('AllREADY_USED', 'Allready Used You Cannot Delete');


defined('LEAVE_TYPE_LIST_NOT_FOUND') OR define('LEAVE_TYPE_LIST_NOT_FOUND', 'Leave Type list not found');
defined('LEAVE_TYPE_LIST_FOUND') OR define('LEAVE_TYPE_LIST_FOUND', 'Leave Type list found');
defined('LEAVE_TYPE_INSERT') OR define('LEAVE_TYPE_INSERT', 'Leave Type data inserted sucessfully');
defined('LEAVE_TYPE_NOT_INSERT') OR define('LEAVE_TYPE_NOT_INSERT', 'Leave Type data not inserted sucessfully');
defined('LEAVE_TYPE_UPDATE') OR define('LEAVE_TYPE_UPDATE', 'Leave Type data updated sucessfully');
defined('LEAVE_TYPE_NOT_UPDATE') OR define('LEAVE_TYPE_NOT_UPDATE', 'Leave Type data not updated sucessfully');
defined('LEAVE_TYPE_DELETE') OR define('LEAVE_TYPE_DELETE', 'Leave Type data deleted sucessfully');
defined('LEAVE_TYPE_NOT_DELETE') OR define('LEAVE_TYPE_NOT_DELETE', 'Leave Type data not deleted sucessfully');

defined('DEPARTMENT_LIST_NOT_FOUND') OR define('DEPARTMENT_LIST_NOT_FOUND', 'Department list not found');
defined('DEPARTMENT_LIST_FOUND') OR define('DEPARTMENT_LIST_FOUND', 'Department list found');
defined('DEPARTMENT_INSERT') OR define('DEPARTMENT_INSERT', 'Department data inserted sucessfully');
defined('DEPARTMENT_NOT_INSERT') OR define('DEPARTMENT_NOT_INSERT', 'Department data not inserted sucessfully');
defined('DEPARTMENT_UPDATE') OR define('DEPARTMENT_UPDATE', 'Department data updated sucessfully');
defined('DEPARTMENT_NOT_UPDATE') OR define('DEPARTMENT_NOT_UPDATE', 'Department data not updated sucessfully');
defined('DEPARTMENT_DELETE') OR define('DEPARTMENT_DELETE', 'Department data deleted sucessfully');
defined('DEPARTMENT_NOT_DELETE') OR define('DEPARTMENT_NOT_DELETE', 'Department data not deleted sucessfully');

defined('DEPARTMENT_LEAVE_LIST_NOT_FOUND') OR define('DEPARTMENT_LEAVE_LIST_NOT_FOUND', 'Department Leave list not found');
defined('DEPARTMENT_LEAVE_LIST_FOUND') OR define('DEPARTMENT_LEAVE_LIST_FOUND', 'Department Leave list found');
defined('DEPARTMENT_LEAVE_INSERT') OR define('DEPARTMENT_LEAVE_INSERT', 'Department Leave inserted sucessfully');
defined('DEPARTMENT_LEAVE_NOT_INSERT') OR define('DEPARTMENT_LEAVE_NOT_INSERT', 'Department Leave not inserted sucessfully');
defined('DEPARTMENT_LEAVE_UPDATE') OR define('DEPARTMENT_LEAVE_UPDATE', 'Department Leave updated sucessfully');
defined('DEPARTMENT_LEAVE_NOT_UPDATE') OR define('DEPARTMENT_LEAVE_NOT_UPDATE', 'Department Leave not updated sucessfully');
defined('DEPARTMENT_LEAVE_DELETE') OR define('DEPARTMENT_LEAVE_DELETE', 'Department Leave deleted sucessfully');
defined('DEPARTMENT_LEAVE_NOT_DELETE') OR define('DEPARTMENT_LEAVE_NOT_DELETE', 'Department Leave not deleted sucessfully');

defined('ASSETS_LIST_NOT_FOUND') OR define('ASSETS_LIST_NOT_FOUND', 'Asset list not found');
defined('ASSETS_LIST_FOUND') OR define('ASSETS_LIST_FOUND', 'Asset list found');
defined('ASSETS_INSERT') OR define('ASSETS_INSERT', 'Asset inserted sucessfully');
defined('ASSETS_NOT_INSERT') OR define('ASSETS_NOT_INSERT', 'Asset not inserted sucessfully');
defined('ASSETS_UPDATE') OR define('ASSETS_UPDATE', 'Asset updated sucessfully');
defined('ASSETS_NOT_UPDATE') OR define('ASSETS_NOT_UPDATE', 'Asset not updated sucessfully');
defined('ASSETS_DELETE') OR define('ASSETS_DELETE', 'Asset deleted sucessfully');
defined('ASSETS_NOT_DELETE') OR define('ASSETS_NOT_DELETE', 'Asset not deleted sucessfully');
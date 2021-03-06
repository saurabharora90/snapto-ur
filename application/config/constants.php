<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|My Constats
*/

//Remeber to remove development storage during deployment.
define('blobConnectionString', 'DefaultEndpointsProtocol=http;AccountName=snaptour;AccountKey=Z2il1KKalrKC+ggAMPITnRZpLidWbg+S+N2TYpebGNPDgyrHm/G1o5tJGZeEcmU3z4lxIqdNzA8mflj+pDecdg==');
define('tableConnectionString', 'DefaultEndpointsProtocol=http;AccountName=snaptour;AccountKey=Z2il1KKalrKC+ggAMPITnRZpLidWbg+S+N2TYpebGNPDgyrHm/G1o5tJGZeEcmU3z4lxIqdNzA8mflj+pDecdg==');
define('Actual_Image',  'imageuploads');
define('Thumbnail', 'thumbnails');
define('Metadata_table', 'metadata');

if(ENVIRONMENT == 'development')
{
    define('Actual_Image_blobURL', 'http://127.0.0.1:10000/devstoreaccount1/imageuploads/');
    define('Thumbnail_Image_blobURL', 'http://127.0.0.1:10000/devstoreaccount1/thumbnails/');
}
else
{
    define('Actual_Image_blobURL', 'http://snaptour.blob.core.windows.net/imageuploads/');
    define('Thumbnail_Image_blobURL', 'http://snaptour.blob.core.windows.net/thumbnails/');
}
//define('Metadata_Table', )
/* End of file constants.php */
/* Location: ./application/config/constants.php */
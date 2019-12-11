<?php
namespace App\Controller\Component;
/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';

chdir(dirname(__DIR__));
require('./src/Controller/Component/AdminCommonComponent.php');

function move_uploaded_file($filename, $destination)
{
    //Copy file
    return copy($filename, $destination);
}

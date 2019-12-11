<?php
/**
 * Created by PhpStorm.
 * User: truong
 * Date: 8/11/18
 * Time: 4:43 PM
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected function getDefaultResponse() {
        $response = [];
        $response['status_code'] = 200;
//        $response['data'] = [];
//        $response['message'] = '';
//        $response['errors'] = [];

        return $response;
    }
}

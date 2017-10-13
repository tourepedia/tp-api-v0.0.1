<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PermissionsController extends Controller
{

    public function __construct(Application $app)
    {
        $app->configure('permissions');
    }

    /**
     * Show the application permissions for $for object.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $for)
    {
        $permissions = array();
        switch ($for) {
            case "user":
                $permissions = config("permissions.user");
                break;
            default:
                throw new BadRequestHttpException("Invalid permission's request.");
                break;
        }
        return  ["data" => $permissions];
    }
}

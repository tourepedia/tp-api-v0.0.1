<?php

namespace App\Http\Controllers\Constants;

use Illuminate\Http\Request;
use App\Http\Controllers\Constants\Controller;

use App\Models\Constants\UserRole as Role;
use Auth;

class UserRolesController extends Controller
{

    /**
     * Name of the model associate with the Controller
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = Role::class;


    /**
     * Show an item
     * @param  Reques $request [description]
     * @param  [type] $role_id [description]
     * @return [type]          [description]
     */
    public function getItem($role_id)
    {
        return $this->model::where("id", $role_id)->first();
    }


    /**
     * Updae permissions for a role
     * @param  Request $request [description]
     * @param  Role    $role    [description]
     * @return [type]           [description]
     */
    public function updatePermissions(Request $request, Role $role)
    {
        // TODO: validate the request

        $permissions = $request->permissions;

        if (!$permissions) {
            return back();
        }

        $user_id = Auth::id();
        $syncPermissions = [];
        foreach ($permissions as $permission) {
            $syncPermissions[$permission] = [ "created_by" => $user_id ];
        }

        $role->permissions()->sync($syncPermissions);

        return $this->show($request, $role->id);
    }
}

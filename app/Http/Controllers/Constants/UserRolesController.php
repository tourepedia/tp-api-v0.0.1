<?php

namespace App\Http\Controllers\Constants;

use Illuminate\Http\Request;
use App\Http\Controllers\Constants\Controller;

use Auth;
use App\Models\Constants\UserRole as Role;
use App\Models\Permission;

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
        return $this->model::where("id", $role_id)->with("permissions")->first();
    }


    /**
     * Updae permissions for a role
     * @param  Request $request [description]
     * @param  Role    $role    [description]
     * @return [type]           [description]
     */
    public function updatePermissions(Request $request, $role_id)
    {
        $role = $this->model::where("id", $role_id)->first();

        // TODO: validate the request

        $permissions = $request->permissions;
        $user_id = Auth::id();

        // inactive the permission
        $role->permissions()->update(["is_active" => 0]);

        foreach ($permissions as $permission) {
            $new_permission = new Permission();
            $new_permission->permission = $permission;
            $new_permission->created_by = $user_id;

            $role->permissions()->save($new_permission);
        }

        return $this->show($request, $role->id);
    }
}

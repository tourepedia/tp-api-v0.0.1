<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contants\UserRole as Role;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $users = User::with("roles")->get();

        return ["data" => $users];
    }


    /**
     * Show the user data
     * @param  Request $request      [description]
     * @param  [type]  $user_id [description]
     * @return [type]            [description]
     */
    public function show(Request $request, $user_id)
    {
        $user = User::where("id", $user_id)->with("roles")->first();

        if (!$user) {
            throw new NotFoundHttpException("User not found.");
        }

        return ["data" => $user];
    }

    /**
     * Update the role of a user
     */
    public function updateRoles(Request $request, $user_id)
    {
        // TODO: only allow admin users to update the role
        $roles = $request->roles;

        $user = User::findOrFail($user_id);

        $syncRoles = [];
        foreach ($roles as $role_id) {
            $syncRoles[$role_id] = ["created_by" => Auth::id()];
        }

        $user->roles()->sync($syncRoles);

        return $this->show($request, $user_id);
    }
}

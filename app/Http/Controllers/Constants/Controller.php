<?php

namespace App\Http\Controllers\Constants;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller as BaseController;

use App\Models\Constant;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    protected $model = Constant::class;

    public function index()
    {
        return ["data" => $this->constants()];
    }

    public function show(Request $request, $constant_id)
    {
        $constant = $this->getItem($constant_id);
        if (!$constant) {
            throw new NotFoundHttpException("Role not found.");
        }
        return ["data" => $this->model::where("id", $constant_id)->first()];
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $description = $request->description;

        $constant = $this->new();

        $constant->name = $name;
        $constant->description = $description;
        $constant->created_by = Auth::id();
        $constant->save();

        return $this->show($request, $constant->id);
    }

    public function getItem($role_id)
    {
        return $this->model::where("id", $role_id)->first();
    }


    public function constants()
    {
        return $this->model::get();
    }

    public function new()
    {
        return new $this->model();
    }
}

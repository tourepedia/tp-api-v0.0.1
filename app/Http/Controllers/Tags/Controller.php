<?php

namespace App\Http\Controllers\Tags;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller as BaseController;

use App\Models\Tag;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    protected $model = Tag::class;

    public function index()
    {
        return ["data" => $this->tags()];
    }

    public function show(Request $request, $constant_id)
    {
        $constant = $this->getItem($constant_id);
        if (!$constant) {
            throw new NotFoundHttpException("Role not found.");
        }
        return ["data" => $constant];
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


    public function tags()
    {
        return $this->model::get();
    }

    public function new()
    {
        return new $this->model();
    }
}

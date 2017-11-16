<?php

namespace App\Http\Controllers\Tags;

use Illuminate\Http\Request;
use App\Http\Controllers\Tags\Controller;

use Auth;
use App\Models\Tags\RoomType;
use App\Models\Permission;

class RoomTypesController extends Controller
{

    /**
     * Name of the model associate with the Controller
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = RoomType::class;
}

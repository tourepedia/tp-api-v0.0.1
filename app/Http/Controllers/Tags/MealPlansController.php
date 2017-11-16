<?php

namespace App\Http\Controllers\Tags;

use Illuminate\Http\Request;
use App\Http\Controllers\Tags\Controller;

use Auth;
use App\Models\Tags\MealPlan;
use App\Models\Permission;

class MealPlansController extends Controller
{

    /**
     * Name of the model associate with the Controller
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = MealPlan::class;
}

<?php

namespace App\Http\Controllers\Constants;

use Illuminate\Http\Request;
use App\Http\Controllers\Constants\Controller;

use Auth;
use App\Models\Constants\HotelMealPlan as MealPlan;
use App\Models\Permission;

class HotelMealPlansController extends Controller
{

    /**
     * Name of the model associate with the Controller
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model = MealPlan::class;
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->get("q");

        $locations = Location::when($q, function ($query) use ($q) {
            $query->where("short_name", "like", "%$q%");
        })->limit(50)->get();

        // if short_name gives less then 5 results, search on full name for the locations
        if ($locations->count() < 10) {
            $locations = Location::when($q, function ($query) use ($q) {
                $query->where("name", "like", "%$q%");
            })->limit(50)->get();
        }
        return ["data" => $locations];
    }
}

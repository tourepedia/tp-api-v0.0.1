<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Hotel;
use App\Models\Location;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\HotelPrice;
use App\Models\Price;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dingo\Api\Exception\ResourceException;

class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::with("locations")->get();

        return ["data" => $hotels];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::where("country_id", 101)
            ->select("id", "short_name", "name")->orderBy("short_name")->get();
        return view("hotels.new", ["locations" => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: validate the user input
        $name = $request->name;
        $locations = $request->locations;
        $roomTypes = $request->roomTypes;
        $mealPlans = $request->mealPlans;
        $eb_child_age_start = $request->eb_child_age_start;
        $eb_child_age_end = $request->eb_child_age_end;


        $creator = Auth::id();

        $hotel = new Hotel();
        $hotel->name = $name;
        $hotel->created_by = $creator;
        $hotel->eb_child_age_start = $eb_child_age_start;
        $hotel->eb_child_age_end = $eb_child_age_end;

        $toAttachLocations = array();
        foreach ($locations as $locationId) {
            $toAttachLocations[$locationId] = ["created_by" => $creator];
        }

        $toAttachRoomTypes = array();
        foreach ($roomTypes as $roomTypeId) {
            $toAttachRoomTypes[$roomTypeId] = ["created_by" => $creator];
        }

        $toAttachMealPlans = array();
        foreach ($mealPlans as $mealPlanId) {
            $toAttachMealPlans[$mealPlanId] = ["created_by" => $creator];
        }


        DB::beginTransaction();
        $hotel->save();
        if (count($toAttachLocations)) {
            $hotel->locations()->attach($toAttachLocations);
        }

        if (count($toAttachRoomTypes)) {
            $hotel->roomTypes()->attach($toAttachRoomTypes);
        }

        if (count($toAttachMealPlans)) {
            $hotel->mealPlans()->attach($toAttachMealPlans);
        }

        DB::commit();

        return $this->show($request, $hotel->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $hotel_id)
    {

        $hotel = Hotel::where("id", $hotel_id)
            ->with("locations", "contacts", "roomTypes", "mealPlans", "prices")->first();

        if (!$hotel) {
            throw new NotFoundHttpException("Hotel not found.");
        }

        return ["data" => $hotel];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        //
    }

    public function storePrice(Request $request, $hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        if (!$hotel) {
            throw new NotFoundHttpException("Hotel not found.");
        }

        $data = $request->only(
            "locations",
            "meal_plans",
            "room_types",
            "intervals"
        );

        $data["created_by"] = Auth::id();

        // start the transaction
        DB::beginTransaction();

        foreach ($data["intervals"] as $interval) {
            $start_date = $interval["start_date"];
            $end_date = $interval["end_date"];
            // for each location
            foreach ($data["locations"] as $location) {
                // for each room types
                foreach ($data["room_types"] as $room_type) {
                    // for each meal plan's prices
                    foreach ($data["meal_plans"] as $meal_plan => $prices) {
                        $hotelPrice = new HotelPrice();
                        $hotelPrice->location_id = $location;
                        $hotelPrice->room_type_id = $room_type;
                        $hotelPrice->meal_plan_id = $meal_plan;
                        $hotelPrice->start_date = $start_date;
                        $hotelPrice->end_date = $end_date;

                        // now store the price values
                        $hotelPrice->base_price = $prices["base_price"];
                        $hotelPrice->a_w_e_b = $prices["a_w_e_b"];
                        $hotelPrice->c_w_e_b = $prices["c_w_e_b"];
                        $hotelPrice->c_wo_e_b = $prices["c_wo_e_b"];

                        // attach the price to the hotel
                        $hotel->prices()->save($hotelPrice);
                    }
                }
            }
        }

        DB::commit();

        return $this->show($request, $hotel->id);
    }

    public function addContact(Request $request, $hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        return view("hotels.addContact", ["hotel" => $hotel]);
    }

    public function storeContact(Request $request, $hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);


        // TODO: validate the data
        $name = $request->name;
        $phone_number = $request->phone_number;
        $email = $request->email;

        $created_by = Auth::id();

        // create contact and phone entries and bined
        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->created_by = $created_by;

        $phone = new Phone();
        $phone->phone_number = $phone_number;
        $phone->created_by = $created_by;


        DB::beginTransaction();

        $contact->save();
        $contact->phones()->save($phone);
        $hotel->contacts()->attach($contact->id, ["created_by" => $created_by]);

        DB::commit();

        return $this->show($request, $hotel_id);
    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "q" => "required",
        ]);

        if ($validator->fails()) {
            throw new ResourceException('Invalid request.', $validator->errors());
        }

        $q = $request->get("q");
        $with = $request->get("with");
        $tripStartDate = $request->get("tripStartDate");

        $hotels = Hotel::where(function ($query) use ($q) {
            return $query->where("name", "LIKE", "%$q%")
            ->orWhereHas("locations", function ($location) use ($q) {
                return $location->where("name", "LIKE", "%$q%");
            });
        })->when($with && array_search("prices", $with) !== false, function ($query) use ($tripStartDate) {
            return $query->when($tripStartDate, function ($q) use ($tripStartDate) {
                return $q->whereHas("prices", function ($prices) use ($tripStartDate) {
                    return $prices->where("start_date", "<=", $tripStartDate)->where("end_date", ">=", $tripStartDate);
                });
            })->with(["prices" => function ($prices) use ($tripStartDate) {
                if ($tripStartDate) {
                    return $prices->where("start_date", "<=", $tripStartDate)->where("end_date", ">=", $tripStartDate);
                }
                return $prices;
            }]);
        })->with("locations")->limit(20)->get();

        return ["data" => $hotels];
    }
}

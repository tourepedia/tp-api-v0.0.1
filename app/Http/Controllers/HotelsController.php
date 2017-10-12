<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Hotel;
use App\Models\Location;
use App\Models\Contact;
use App\Models\Phone;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HotelsController extends Controller
{

    protected $room_types = array(
        array("id" => 1, "label" => "Single", "description" => "A room which has single bed facility"),
        array("id" => 1, "label" => "Double", "description" => "A room which has double bed facility"),
        array("id" => 1, "label" => "Double-double", "description" => "A room which has two double bed facility seperated by a center table"),
        array("id" => 1, "label" => "Twin", "description" => "A room which has two single bed seperated by a center table"),
        array("id" => 1, "label" => "Interconnecting", "description" => "Two rooms which shares a common door, mostly used by families"),
        array("id" => 1, "label" => "Adjoining", "description" => "Two rooms which share a common wall, mostly preferred by groups"),
        array("id" => 1, "label" => "Hollywood Twin", "description" => "A room which ahs two single bed but shares a common head board"),
        array("id" => 1, "label" => "Duplex", "description" => "A room which is been spread on two floors connected by an internal staicase"),
        array("id" => 1, "label" => "Canaba", "description" => "A room which is near a water body or beside swimming pool"),
        array("id" => 1, "label" => "Studio", "description" => "A room with a sofa-cum-bed facility"),
        array("id" => 1, "label" => "Parlor", "description" => "A room which is used for sitting and cannot be used for sleeping purpose"),
        array("id" => 1, "label" => "Lanai", "description" => "A room which oversees a scenic beauty e.g. Garden, landscape or water fall"),
        array("id" => 1, "label" => "Efficiency", "description" => "A room with a kitchen facility"),
        array("id" => 1, "label" => "Hospitality", "description" => "A room where hotel staff would entertain their guests"),
        array("id" => 1, "label" => "Suit", "description" => "A room comparises of two or more bedroom, a living room and a dining area"),
        array("id" => 1, "label" => "King", "description" => "A room with a king sized bed"),
        array("id" => 1, "label" => "Queen", "description" => "A room with a queen sized bed"),
    );

    protected $meal_plans = array(
        array("id" => 1, "label" => "AP", "description" => "American Plan (Breakfast, Lunch & Dinner)"),
        array("id" => 2, "label" => "MAP", "description" => "Modified American Plan (Two meals: Breakfast and one of Lunch or Dinner)"),
        array("id" => 3, "label" => "CP", "description" => "Continental Plan (Breakfast)"),
        array("id" => 4, "label" => "EP", "description" => "European Plan (No Meal)"),
    );


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
        $locations = Location::where("country_id", 101)->select("id", "short_name", "name")->orderBy("short_name")->get();
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


        $creator = Auth::id();

        $hotel = new Hotel();
        $hotel->name = $name;
        $hotel->created_by = $creator;

        // bind trip and location
        $toAttachLocations = array();
        foreach ($locations as $locationId) {
            $toAttachLocations[$locationId] = ["created_by" => $creator];
        }

        DB::beginTransaction();
        $hotel->save();
        if (count($toAttachLocations)) {
            $hotel->locations()->attach($toAttachLocations);
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

        $hotel = Hotel::where("id", $hotel_id)->with("locations", "contacts")->first();

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

    public function addPricing(Request $request, $hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        return view("hotels.addPricing", ["hotel" => $hotel, "room_types" => $this->room_types, "meal_plans" => $this->meal_plans]);
    }

    public function storePricing(Request $request, $hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        return redirect()->route("hotel", ["hotel_id" => $hotel->id]);
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
}

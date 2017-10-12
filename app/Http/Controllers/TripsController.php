<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Price;
use App\Models\Quote;

class TripsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }



    /**
     * Return the list of trips
     * @return View -- view with trips
     */
    public function index(Request $req)
    {
        // store the input for next request
        $req->flashOnly(["q"]);

        $q = $req->q;
        $trips = Trip::with([
            "contacts" => function ($contact) {
                $contact->with(["phones"]);
            },
            "locations",
            "creator",
            "quotes"
            ])
        ->when($q, function ($trips) use ($q) {
            return $trips->where("title", "LIKE", "%".$q."%")
                ->orWhere("source_id", "LIKE", "%".$q."%");
        })
        ->orderBy("created_at", "DESC")
        ->get();

        return view("trips.list", ["trips" => $trips]);
    }





    /**
     * Get a particular trip
     * @param  Request $req     -- request
     * @param  Integer  $trip_id -- trip id
     * @return View           -- View with trip data
     */
    public function show(Request $req, $trip_id)
    {
        $trip = Trip::where("id", $trip_id)->with([
            "locations",
            "contacts",
            "quotes",
            ])->first();
        return view("trips.show", ["trip" => $trip]);
    }



    /**
     * Create a new trip
     */
    public function create(){
        $destinations = Location::where("country_id", 101)->whereNull("city_id")->whereNotNull("state_id")->select("id", "short_name", "name")->get();
        return view("trips.new", ["destinations" => $destinations]);
    }



    /**
     * Create a trip
     * @param  Request $req -- comming request
     * @return view       -- list view of trips if success else return errors
     */
    public function store(Request $req)
    {
        $data = $req->only(
            "title",
            "destinations",
            "source_id",
            "no_of_days",
            "start_date",
            "short_itinerary",
            "contact_name",
            "contact_number",
            "contact_email",
            "group_details",
            "hotels_details",
            "travel_details",
            "quote_price",
            "comments"
            );

        $data["created_by"] = Auth::id();

        $data["start_date"] = $data["start_date"];


        // add entry into trips table
        $trip = new Trip();
        $trip->title = $data["title"];
        $trip->source_id = $data["source_id"];
        $trip->created_by = $data["created_by"];
        $trip->last_updated_by = $data["created_by"];
        $trip->start_date = $data["start_date"];
        $trip->no_of_days = $data["no_of_days"];
        $trip->group_details = $data["group_details"];


        $quote = new Quote();
        $quote->short_itinerary = $data["short_itinerary"];
        $quote->hotels_details = $data["hotels_details"];
        $quote->travel_details = $data["travel_details"];
        $quote->comments = $data["comments"];
        $quote->created_by = $data["created_by"];

        // bind trip and location
        $toAttachLocations = array();
        foreach ($data["destinations"] as $locationId) {
            $toAttachLocations[$locationId] = ["created_by" => $data["created_by"]];
        }


        // create contact and phone entries and bined
        $contact = new Contact();
        $contact->name = $data["contact_name"];
        $contact->email = $data["contact_email"];
        $contact->created_by = $data["created_by"];


        $phone = new Phone();
        $phone->phone_number = $data["contact_number"];
        $phone->created_by = $data["created_by"];

        // create price
        $price = new Price();
        $price->value = $data["quote_price"];
        $price->created_by = $data["created_by"];

        // start the transaction
        DB::beginTransaction();

        $trip->save();

        if (count($toAttachLocations)) {
            $trip->locations()->attach($toAttachLocations);
        }


        $trip->quotes()->save($quote);

        $quote->prices()->save($price);

        $contact->save();

        $contact->phones()->save($phone);

        // bind contact and trip
        $trip->contacts()->attach($contact->id, ["created_by" => $data["created_by"]]);


        DB::commit();

        return redirect()->route("trips");
    }
}

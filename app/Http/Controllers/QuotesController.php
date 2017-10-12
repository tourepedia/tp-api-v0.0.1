<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Trip;
use App\Models\Price;
use Auth;
use DB;

class QuotesController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }


    /**
     * Edit a quote
     */
    public function edit(Request $req, $quote_id)
    {
        $quote = Quote::where("id", $quote_id)->with("trip", "prices")->first();

        return view("trips.quotes.edit", ["quote" => $quote]);
    }




    /**
     * Update a quote
     */
    public function update(Request $req, $quote_id)
    {
        $quote = Quote::findOrFail($quote_id);

        $quote->is_active = 0;

        $data = $req->only(
            "short_itinerary",
            "hotels_details",
            "travel_details",
            "quote_price",
            "comments"
            );

        $data["created_by"] = Auth::id();

        $new_quote = new Quote();
        $new_quote->short_itinerary = $data["short_itinerary"];
        $new_quote->hotels_details = $data["hotels_details"];
        $new_quote->travel_details = $data["travel_details"];
        $new_quote->comments = $data["comments"];
        $new_quote->created_by = $data["created_by"];
        $new_quote->trip_id = $quote->trip_id;

        // create price
        $price = new Price();
        $price->value = $data["quote_price"];
        $price->created_by = $data["created_by"];

        // start the transaction
        DB::beginTransaction();

        // update the old quote, make it in_active
        $quote->save();

        // save the new quote
        $new_quote->save();

        // save the new price
        $new_quote->prices()->save($price);

        DB::commit();

        return redirect()->route("trip", ["trip_id" => $quote->trip_id]);
    }


}

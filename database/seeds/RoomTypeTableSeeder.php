<?php

use Illuminate\Database\Seeder;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $roomTypes = [
        "Twin" =>    "A room which has two single bed separated by a center table",
        "Deluxe" =>   "Special",
        "Super Room"  =>   "Base Category Room",
        "Superior Room"  =>   "Middle Category Room",
        "Suit Room"  =>  "Highest Category Room",
        "Executive Room"  =>  "Good Room",
        "Super Deluxe Room"  =>  "upper category room",
        "Swiss Tent" =>   "Tented Accommodation",
        "Cottage Room"  =>  "Traditional Style Room",
        "Luxury Lake View Room"  =>  "Lake facing Room",
        "Royal Deluxe Room"  =>  "Decent Room",
        "Premium Room" =>   "Great Room",
        "Premier Room"  =>  "Great Room",
        "Suit Lake View Room" =>   "Highest Category Room",
        "Club Room"  =>  "Good Category Room",
        "Maharaja Villas Tent" =>   "Great quality tent",
        "Rajwada Tent" =>   "Decent Tent",
        "Deluxe Tent" =>   "Base Tent",
        "AC Deluxe Tent" =>   "Quality Tent with AC",
        "Rajputana Chambers" =>   "Pool view room of ITC Rajputana",
        "Pavilion Room" =>   "Base Category Room",
        "Fort Room" =>   "Better than base category",
        "Garden Room"  =>   "Base category of Balsamand Lake Palace",
        "Regal Suit Room" =>    "Highest Category room of Balsamand Lake Palace",
        "Royal Villa Room" =>    "Highest Category Room of Bhanwar Singh Palace",
        "Royal Room" =>    "Base Category of Bhanwar Singh Palace",
    ];
    public function run()
    {
        foreach ($this->roomTypes as $name => $description) {
            $roomType = new App\Models\Tags\RoomType();
            $roomType->name = $name;
            $roomType->description = $description;
            $roomType->created_by = 1;
            $roomType->save();
        }
    }
}

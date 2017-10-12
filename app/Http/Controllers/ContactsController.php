<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Phone;
use Auth;
use DB;

class ContactsController extends Controller
{

    public function index()
    {
        $contacts = Contact::with("phones")->get();
        return ["contacts" => $contacts];
    }

    public function create()
    {
        return view("contacts.new");
    }

    public function store(Request $req)
    {
        $name = $req->name;
        $phone_number = $req->phone_number;
        $email = $req->email;

        DB::beginTransaction();

        // create contact and phone entries and bined
        $contact = new Contact();
        $contact->name = $name;
        $contact->email = $email;
        $contact->created_by = Auth::id();
        $contact->save();

        $phone = new Phone();
        $phone->phone_number = $phone_number;
        $phone->created_by = Auth::id();
        $contact->phones()->save($phone);

        DB::commit();

        if (!$contact->phones) {
            $contact->load("phones");
        }
        return ["contact" => $contact];
    }

    public function show(Request $req, $contact_id)
    {
        $contact = Contact::where("id", $contact_id)->with("phones", "hotels", "trips")->first();

        return ["contact" => $contact];
    }
}

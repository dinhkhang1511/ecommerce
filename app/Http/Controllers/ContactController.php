<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ContactController extends Controller
{
    public function index()
    {

        $data = GetData()->getDataWithParam('contacts',request()->all());
        if(isset($data->contacts))
        {
            $contacts = $data->contacts;
            return view('backend.contact.index', compact('contacts'));
        }

        return abort(404);

    }

    public function create()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name'    =>'required',
                            'message' => 'required',
                            'email'   => 'required|email']);

        $response = Http::post("$this->api_url/contacts",$validated);
        if($response->successful())
        {
            // $contact = $this->respondToData($response);
            return success('contact.create');
        }
        else
            $response->throw();
    }
}

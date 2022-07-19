<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = ContactMessage::latest()->paginate(10);
        return view('backend.contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('frontend.contact');
    }

    public function store()
    {
        ContactMessage::create(request()->all());
        return success('contact.create');
    }
}

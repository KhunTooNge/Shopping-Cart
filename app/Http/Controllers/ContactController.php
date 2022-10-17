<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // user contact page
    public function contact()
    {
        return view('user.main.contact');
    }

    // create contact
    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ])->validate();

        Contact::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with(['message' => 'Successfuly send']);
    }

    // admin contact page
    public function adminContactPage()
    {
        $contact = Contact::when(request('keys'), function ($query) {
            $query->where('name', 'like', '%' . request('keys') . '%')->paginate(4);
        })->orderBy('created_at')->paginate(4);

        $contact->appends(request()->all());

        return view('admin.contact.contact', compact('contact'));
    }
}

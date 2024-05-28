<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view(
            'setting.contact.index',
            [
                'title' => 'Contact Page'
            ]
        );
    }

    public function edit($id)
    {
        $contact = Contact::find($id);
        return view(
            'setting.contact.edit',
            [
                'title' => 'Edit Contact' . ' ' . $contact->name,
                'contact' => $contact
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|min:5|unique:contacts,name,' . $id,
            'type' => 'required',
            'description' => 'required'
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());
        return redirect('/setting/contact')->with('success', 'Contact has been updated');
    }
}

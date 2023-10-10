<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactController extends Controller
{
    public function __construct()
  {
    $this->middleware('permission:show_contactUs', ['only'=>'index', 'show']);
    $this->middleware('permission:delete_contactUs', ['only'=>'destroy']);
  }
    public function index()
    {
        $contacts = Contact::orderBy('id','desc')->get();
        return view('admin.website.contacts.index', compact('contacts'));
    }

    

    public function show(Contact $contact)
    {
        $is_readed = [
            'is_readed' => 1,
        ];
        $contact->update($is_readed);
        return view('admin.website.contacts.show', compact('contact')); 
    }

    
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact) {
            $contact->delete();
        }
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('contacts.index')->with($notification);
    }
}

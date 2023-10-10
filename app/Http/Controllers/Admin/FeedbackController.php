<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;

class FeedbackController extends Controller
{

    public function index()
    {
        $contacts = Feedback::get();
        return view('admin.website.feedbacks.index', compact('contacts'));
    }

    

    public function show(Contact $contact)
    {
        $is_readed = [
            'is_readed' => 1,
        ];
        $contact->update($is_readed);
        return view('admin.website.feedbacks.show', compact('contact')); 
    }

    
    public function destroy($id)
    {
        $contact = Feedback::findOrFail($id);
        if ($contact) {
            $contact->delete();
        }
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return redirect()->route('feedbacks.index')->with($notification);
    }
}

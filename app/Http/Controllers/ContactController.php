<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function addContact(Request $request)
    {
        $contact = $request->only(
            'name',
            'email',
            'title',
            'message',
        );
        Contact::create($contact);
        return redirect()->route('home')->with('msg', "Gửi lời nhắn thành công. Cảm ơn bạn đã gửi.");
    }
}
